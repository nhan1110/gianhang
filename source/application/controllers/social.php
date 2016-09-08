<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Social extends CI_Controller
{
    private $base_url = '';
    //Facebook
    private $appId='504938483038513';//1270638292949843
    private $secret='65d1e6aecb9d35541928bdf49080c14a';//a1fa93fd56865446ac0a6ff1f98cfc17

    //Google
    private $clientId = '286803671750-vqedb5ggu3dsiea8429j529nnp6vik87.apps.googleusercontent.com'; //Google CLIENT ID
    private $clientSecret = '0KpIjf5EF4XbMOO9ayQfrHQT'; //Google CLIENT SECRET
    private $redirectUrl = 'social/google/';  //return url (url to script)
    private $homeUrl = '/';


	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        if ($this->session->userdata('user_info')) {
            redirect(base_url());
            die;
        }
        $this->base_url = base_url();
        $this->redirectUrl = $this->base_url.$this->redirectUrl;
        $this->homeUrl  = $this->base_url;
    }

    public function facebook(){
        include_once("Social/FaceBook/facebook.php");
        // Create our Application instance (replace this with your appId and secret).
        $facebook = new Facebook(array(
          'appId'  => $this->appId,
          'secret' => $this->secret
        ));

        // Get User ID
        $user = $facebook->getUser();
        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.
        if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me?fields=first_name,last_name,email,picture.type(large)');
                //$user_profile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }
        // Login or logout url will be needed depending on current user state.
        if ($user) {
            $logoutUrl = $facebook->getLogoutUrl();
        } else {
            $loginUrl = $facebook->getLoginUrl();
            redirect($loginUrl);
            die;
        }
        
       

        if($user){
            $email = $user_profile['email'];
            $first_name = $user_profile['first_name'];
            $last_name = $user_profile['last_name'];
            if(isset($email) && $email!=null){
                //signin successfully
                $member=new Member();
                $member->where('Email',$email)->get(1);
                if (isset($member->ID) && $member->ID!=null) {
                    $message = "Email tài khoản Facebook này đã tồn tại. Vui lòng đăng nhập bằng tài khoản khác.";
                    $this->session->set_userdata('error_login',$message);
                    redirect(base_url());
                    die;
                }
                $password = time();
                $user=new Member();
                $user->Email = $email;
                $user->Firstname = $first_name;
                $user->Lastname = $last_name;
                $user->Avatar = $user_profile['picture']['data']['url'];
                $user->Pwd = md5(md5($email) . md5($password));
                $user->Token = md5(uniqid() . $email);
                $user->Createat = date('Y-m-d H:i:s');
                if ($user->save()) {
                    $token_activity = set_token();
                    $this->session->set_userdata('user_info', array(
                        'email' => $user->Email,
                        'id' => $user->get_id_last_save(),
                        'full_name' => $user->Firstname . ' ' . $user->Lastname,
                        'first_name' => $user->Firstname,
                        'last_name' => $user->Lastname,
                        'avatar' => $user->Avatar,
                        'type_member' => 'Member',
                        'token_activity' => $token_activity
                    ));
                    redirect(base_url());
                    die;
                }
                else{
                    $message = "Lỗi đăng nhập facebook.";
                    $this->session->set_userdata('error_login',$message);
                    redirect(base_url());
                    die;
                }
            }
            else{//error
                $message = "Lỗi đăng nhập facebook.";
                $this->session->set_userdata('error_login',$message);
                redirect(base_url());
                die;
            }
        }
        else{//error
            $message = "Lỗi đăng nhập facebook.";
            $this->session->set_userdata('error_login',$message);
            redirect(base_url());
            die;
        }
    }

    public function google(){
        include_once("Social/Google/Google_Client.php");
        include_once("Social/Google/contrib/Google_Oauth2Service.php");
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($this->clientId);
        $gClient->setClientSecret($this->clientSecret);
        $gClient->setRedirectUri($this->redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        if(isset($_GET['code'])){
            $gClient->authenticate();
            $token = $gClient->getAccessToken();
            $this->session->set_userdata('token', $token);
        }
        if ($this->session->userdata('token')) {
            $gClient->setAccessToken($this->session->userdata('token'));
            $this->session->unset_userdata('token');
        }
        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            $email = $userProfile['email'];
            $first_name = $userProfile['name'];
            $last_name = '';
            if($email!=null){//successfully
                $member=new Member();
                $member->where('Email',$email)->get(1);
                if (isset($member->ID) && $member->ID!=null) {
                    $message = "Email tài khoản Google này đã tồn tại. Vui lòng đăng nhập bằng tài khoản khác.";
                    $this->session->set_userdata('error_login',$message);
                    redirect(base_url());
                    die;
                }
                $password = time();
                $user = new Member();
                $user->Email = $email;
                $user->Firstname = $first_name;
                $user->Lastname = $last_name;
                $user->Avatar = $userProfile['picture'];
                $user->Pwd = md5(md5($email) . md5($password));
                $user->Token = md5(uniqid() . $email);
                $user->Createat = date('Y-m-d H:i:s');
                if ($user->save()) {
                    $token_activity = set_token();
                    $this->session->set_userdata('user_info', array(
                        'email' => $user->Email,
                        'id' => $user->get_id_last_save(),
                        'full_name' => $user->Firstname . ' ' . $user->Lastname,
                        'first_name' => $user->Firstname,
                        'last_name' => $user->Lastname,
                        'avatar' => $user->Avatar,
                        'type_member' => 'Member',
                        'token_activity' => $token_activity
                    ));
                    redirect(base_url());
                    die;
                }
                else{
                    $message = "Lỗi đăng nhập google.";
                    $this->session->set_userdata('error_login',$message);
                    redirect(base_url());
                    die;
                }
            }
            else{//error
                $message = "Lỗi đăng nhập google.";
                $this->session->set_userdata('error_login',$message);
                redirect(base_url());
                die;
            }
        } else {
            $authUrl = $gClient->createAuthUrl();
            redirect($authUrl);
        }
    }

}
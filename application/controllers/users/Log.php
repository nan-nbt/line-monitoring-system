<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tra_factory_model');
		$this->load->model('Tra_users_model');
		$this->load->library('form_validation', 'session');
	}

	// function index
	public function index()
	{
		// $data['tra_factory'] = $this->Tra_factory_model->getAll();
		$this->load->view('users/log/login');
	}

	// function check login session
	public function login()
	{
		$fact_no = $this->input->post('fact_no', true);
		$this->session->set_userdata('factory', $fact_no);

		// redirect url to check session login using SSO V2.0
		redirect(base_url('users/log/loginAuth'));
	}

	// check session oauth 2.0 and open ID access
	public function loginAuth()
	{
		$fact_no = $this->session->userdata('factory');

		if ($fact_no == '0228') {
			$schema = 'pcagleg';
			$dba = $this->load->database('db_pci', true);
			$this->session->set_userdata('schema', $schema);
		} else if ($fact_no == 'B0CV') {
			$schema = 'pgdleg';
			$dba = $this->load->database('db_pgd', true);
			$this->session->set_userdata('schema', $schema);
		} else if ($fact_no == 'B0EM') {
			$schema = 'pgsleg';
			$dba = $this->load->database('db_pgs', true);
			$this->session->set_userdata('schema', $schema);
		} else {
			$this->schema = null;
			$this->dba = null;
			$this->session->set_userdata('schema', $this->schema);
		}

		/**
		 * START
		 * 
		 * Configuration script for using OAuth 2.0 and Open ID Connect 
		 * Provider: Keycloak
		 * Single Sign On (SSO) v2.0
		 */

		$provider = new Stevenmaguire\OAuth2\Client\Provider\Keycloak([
			'authServerUrl'         => 'https://iam.pouchen.com/auth',
			'realm'                 => 'pcg',
			'clientId'              => 'tls-server-5hugjyqx',
			'clientSecret'          => 'wTtfZDh3q075OFxh0beAJdBKQhsAStBU',
			'redirectUri'           => base_url('users/log/loginAuth'),
			'encryptionAlgorithm'   => null,
			'encryptionKeyPath'     => null,
			'encryptionKey'         => null
		]);

		$code = $this->input->get('code');
		$state = $this->input->get('state');

		if (!isset($code)) {
			// If we don't have an authorization code then get one
			$authUrl = $provider->getAuthorizationUrl();
			$this->session->set_userdata('oauth2state', $provider->getState());
			header('Location: ' . $authUrl);
			exit;

			// Check given state against previously stored one to mitigate CSRF attack
		} elseif (empty($state) || ($state !== $this->session->userdata('oauth2state'))) {
			$this->session->unset_userdata('oauth2state');
			exit('Invalid state, make sure HTTP sessions are enabled.');
		} else {
			// Try to get an access token (using the authorization code grant)
			try {
				$token = $provider->getAccessToken('authorization_code', [
					'code' => $code
				]);
			} catch (Exception $e) {
				exit('Failed to get access token: ' . $e->getMessage());
			}

			// Optional: Now you have a token you can look up a users profile data
			try {
				// We got an access token, let's now get the user's details
				$user = $provider->getResourceOwner($token);

				// get user information from API server (array associative)
				$userinfo = $user->toArray();

				/**
				 * START
				 * login method to check user data
				 */
				$data_factory = $this->Tra_factory_model->getById($schema, $dba, $fact_no);
				$data_user = $this->Tra_users_model->getByPCCUID($schema, $dba, $fact_no, $userinfo['pccuid']);

				if (count($data_factory) > 0 && count($data_user) > 0) {
					foreach ($data_factory as $factory) {
						foreach ($data_user as $users) {
							if ($userinfo['pccuid'] == $users->pcc_id && $fact_no == $factory->fact_no && $users->fact_no == $factory->fact_no && $users->depart != 'HSE') {

								$this->session->set_userdata('factory', $factory->fact_no);
								$this->session->set_userdata('sap_factory', $factory->sap_fact_no);
								$this->session->set_userdata('factory_name', $factory->fact_name);
								$this->session->set_userdata('userno', $users->user_no);
								$this->session->set_userdata('username', $userinfo['name']);
								$this->session->set_userdata('level', $users->user_mk);
								$this->Tra_users_model->updateLoginTime($schema, $dba, $users->user_no);

								// redirect url to dashboard traffic light system
								redirect(base_url());
							} else {
								$this->session->set_flashdata('warning', 'Incorrect user NO or password! please contact IT if you forget account!');

								// execute function logout
								$this->logout();
							}
						}
					}
				} else {
					$this->session->set_flashdata('warning', 'Account not found in ' . $fact_no . ' factory!');

					// execute function logout
					$this->logout();
				}
				/**
				 * END
				 * login method to check user data
				 */
			} catch (Exception $e) {
				exit('Failed to get resource owner: ' . $e->getMessage());
			}
		}
		/**
		 * END
		 * 
		 * Configuration script for using OAuth 2.0 and Open ID Connect 
		 * Provider: Keycloak
		 * Single Sign On (SSO) v2.0
		 */
	}

	// direct login
	public function directLogin()
	{
		$fact_no = $this->input->post('guest_fact_no', true);

		if ($fact_no == '0228') {
			$schema = 'pcagleg';
			$dba = $this->load->database('db_pci', true);
			$this->session->set_userdata('schema', $schema);
		} else if ($fact_no == 'B0CV') {
			$schema = 'pgdleg';
			$dba = $this->load->database('db_pgd', true);
			$this->session->set_userdata('schema', $schema);
		} else if ($fact_no == 'B0EM') {
			$schema = 'pgsleg';
			$dba = $this->load->database('db_pgs', true);
			$this->session->set_userdata('schema', $schema);
		} else {
			$this->schema = null;
			$this->dba = null;
			$this->session->set_userdata('schema', $this->schema);
		}

		$data_factory = $this->Tra_factory_model->getById($schema, $dba, $fact_no);

		if (count($data_factory) > 0) {
			foreach ($data_factory as $factory) {
				if ($fact_no == $factory->fact_no) {
					$this->session->set_userdata('factory', $factory->fact_no);
					$this->session->set_userdata('sap_factory', $factory->sap_fact_no);
					$this->session->set_userdata('factory_name', $factory->fact_name);
					redirect(base_url());
				} else {
					$this->session->set_flashdata('warning', 'selected data factory not found!');
					redirect(base_url('users/Log'));
				}
			}
		} else {
			$this->session->set_flashdata('warning', 'database connection not found for this factory!');
			redirect(base_url('users/Log'));
		}
	}

	// function logout session
	public function logout()
	{
		$this->session->unset_userdata('factory');
		$this->session->unset_userdata('sap_factory');
		$this->session->unset_userdata('factory_name');
		$this->session->unset_userdata('userno');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('level');

		// clear session and redirect url to login page
		redirect("https://iam.pouchen.com/auth/realms/pcg/protocol/openid-connect/logout?post_logout_redirect_uri=" . base_url());
	}
}

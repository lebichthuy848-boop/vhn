<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Configs extends Layout {

    function __construct() {
        parent::__construct();
        $this->_data['breadcrumbs_module_name'] = 'Cấu hình';
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Cấu hình',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-config.svg'),
		);
		$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;
    }

    function index() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));

        $post = $this->input->post();
        if (!empty($post)) {
            $data = array(
                'site_email' => $this->input->post('site_email'),
                'site_name' => $this->input->post('site_name'),
                'site_phone' => $this->input->post('site_phone'),
                'site_store' => $this->input->post('site_store'),
                'site_address' => $this->input->post('site_address')
            );
            $this->update_systems($data);

            $notify_type = 'success';
            $notify_content = 'Đã lưu cấu hình!';
            $this->set_notify_admin($notify_type, $notify_content);
            redirect(current_url());
        }

        $this->_data['breadcrumbs_module_func'] = 'Cấu hình';
        $this->_breadcrumbs_admin[] = array(
            'url' => 'settings',
            'name' => $this->_data['breadcrumbs_module_func']
        );

        $this->_data['title'] = 'Cấu hình - ' . $this->_data['title'];
        $configs = $this->M_configs->get_configs();
        $this->_data['configs'] = $this->set_configs($configs);
        $this->_data['main_content'] = 'configs/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    private function set_configs($data) {
        $configs = array();
        foreach ($data as $value) {
            $configs[$value['config_name']] = $value['config_value'];
        }
        return $configs;
    }

    private function update_systems($data) {
        foreach ($data as $key => $value) {
            $this->M_configs->update($key, array('config_value' => $value));
        }
    }

}

/* End of file configs.php */
/* Location: ./application/modules/configs/controllers/configs.php */
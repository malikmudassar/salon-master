<?php

class Discount_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getdiscounttypes() {

        $this->db->select('*');
        $this->db->where('business_discounts.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('business_discounts');

        return $query->result_array();
    }

    function discount_update() {
        $data = array(
            'discount_rate' => $this->input->post('discount_rate', TRUE) ? $this->input->post('discount_rate', TRUE) : NULL,
            'discount_visits' => $this->input->post('discount_visits', TRUE) ? $this->input->post('discount_visits', TRUE) : NULL,
            'discount_purchase' => $this->input->post('discount_purchase', TRUE) ? $this->input->post('discount_purchase', TRUE) : NULL,
            'discount_period' => $this->input->post('discount_period', TRUE) ? $this->input->post('discount_period', TRUE) : NULL,
            'discount_active' => $this->input->post('discount_active', TRUE) ? $this->input->post('discount_active', TRUE) : NULL
        );
        $this->db->set($data);
        $this->db->where('id_business_discounts', $this->input->post('id_business_discounts', TRUE));
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('business_discounts');
        return $this->input->post('id_business_discounts');
    }

    public function create_new_user_discount_pass() {

        $this->db->select('*');
        $this->db->where('discount_password.username', $this->db->escape_str($this->input->post('txtusername')));
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('discount_password');

        if ($query->num_rows() > 0) {
            return $this->input->post('txtusername');
        } else {
            $data = array(
                'business_id' => $this->session->userdata('businessid'),
                'name' => $this->db->escape_str($this->input->post('txtname')),
                'username' => $this->db->escape_str($this->input->post('txtusername')),
                'email' => $this->db->escape_str($this->input->post('txtemail')),
                'password' => md5($this->db->escape_str($this->input->post('txtcnfpass')))
            );
            $this->db->insert('discount_password', $data);
            return $this->db->insert_id();
        }
    }

    public function discount_password_update() {
        if ($this->input->post('current_password') && $this->input->post('current_password') != "") {
            $this->db->select('*');
            $this->db->where('discount_password.username', $this->db->escape_str($this->input->post('name')));
            $this->db->where('discount_password.business_id', $this->session->userdata('businessid'));
            $this->db->where('discount_password.id !=', $this->input->post('passid'));
            $query = $this->db->get('discount_password');
            $result = $query->result();
            if ($query->num_rows() >= 1) {
                return $this->input->post('name');
            } else {
                $this->db->select('*');
                $this->db->where('discount_password.password', md5($this->db->escape_str($this->input->post('current_password'))));
                $this->db->where('discount_password.id', $this->input->post('passid'));
                $this->db->where('discount_password.business_id', $this->session->userdata('businessid'));
                $query = $this->db->get('discount_password');
                if ($query->num_rows() > 0) {
                    $result = $query->row();
                    $password = $result->password;
                    if ($password == md5($this->db->escape_str($this->input->post('current_password')))) {
                        $data = array(
                            'password' => $this->input->post('new_password') ? md5($this->db->escape_str($this->input->post('new_password'))) : $password,
                            'username' => $this->input->post('name'),
                            'email' => $this->input->post('email')
                        );
                        $this->db->set($data);
                        $this->db->where('discount_password.business_id', $this->session->userdata('businessid'));
                        $this->db->where('discount_password.id', $this->input->post('passid', TRUE));
                        $this->db->update('discount_password');
                        return $this->input->post('passid');
                    }
                } else {
                    return FALSE;
                }
            }
        } else {
            $this->db->select('*');
            $this->db->where('business_id', $this->session->userdata('businessid'));
            $query = $this->db->get('discount_password');
            return $query->result();
        }
    }

}

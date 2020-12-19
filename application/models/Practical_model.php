<?php 
class Practical_model extends CI_Model {

    public function insert_entry($table,$data)
    {
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    public function get_data_by_id($table,$id)
    {
        return $this->db->where('Id',$id)->get($table)->result_array();
    }

    public function get_data_by_ref_id($table,$data)
    {
        return $this->db->get_where($table,$data)->result_array();
    }

    public function get_app_data($id)
    {
        return $this->db->select('appointment.*,hospital.Hospital_name,department.Department_name')->from('appointment')->join('hospital','appointment.Hospital_ID  = hospital.Id')->join('department','department.Id = appointment.Department_ID')->where('appointment.User_email',$id)->where('appointment.Is_delete',0)->get()->result_array();
    }
    public function get_all_data($table)
    {
        return $this->db->get($table)->result_array();
    }
    public function check_app_availability($data)
    {
        return $this->db->get_where('appointment',$data)->result_array();
    }

    public function update_data($data,$id,$table)
    {
        return $this->db->where($id)->update($table,$data);
    }
}
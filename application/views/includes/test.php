public  function appointments(){
        if($this->session->userdata('role')==''){
            
            redirect('logout');
            
        } else {
            
            $data['staff_list'] = $this->appointment_model->staff_list();
            $resourceList = "";
            
            foreach ($data['staff_list'] as $staff){
                
                $resourceList .= '{id: '.$staff->id_staff.', ';
                
                $img_path = 'assets/images/staff/';
                $staff_image = file_exists('assets/images/staff/'.$staff->staff_image) ? $img_path.$staff->staff_image : $img_path."no-image.png";
                
                $resourceList .= 'title: "'.$staff->staff_fullname.'"},';
                
            }

            $data['openvisits'] = $this->appointment_model->getOpenVisits();
            $events = "";
            
//            echo "<pre>";
//            print_r($data['openvisits']);
//            echo "</pre>";
//            exit;
            
            foreach ($data['openvisits'] as $visit){
                
                if($visit->visit_service_start != ""){
                
                    $events .= '{id: '.$visit->id_visit_services.', ';
                    $events .= 'resourceId: '.$visit->staff_ids.', ';
                    $events .= 'title: "'.$visit->customer_name.' - visit",';
                    $events .= 'backgroundColor: "'.$visit->service_color.'",';
                    $events .= 'start: "'.$visit->visit_service_start.'",';
                    $events .= 'end: "'.$visit->visit_service_end.'"},';
                
                }
                
            }
            
            $data['resources'] = rtrim($resourceList, ',');
            $data['events'] = rtrim($events, ',');
            
//            echo "<pre>";
//            print_r($data['events']);
//            echo "</pre>";
//            exit;
            
            $this->load->view('includes/header');
            $this->load->view('scheduler_view', $data);
            $this->load->view('includes/footer');
            
        }
    }
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Thumb
{
    private $_width = 200;
    private $_height = 200;
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function createImageThumb($fileData, $source_path, $target_path)
    {
      
        $source_file = $source_path . $fileData['file_name'];
        $target_file = $target_path . $fileData['file_name'];
       
        $imgdata = array();
        $thumb_name = "";
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_file,
            'new_image' => $target_file,
            'maintain_ratio' => true,
            'create_thumb' => true,
            'thumb_marker' => '_thumb'
        );
        // print_r($config_manip);exit();
        
        if ($fileData['image_width'] >= $fileData['image_height']){
            $config_manip['width'] = $this->_width;
        }
        else{
            $config_manip['height'] = $this->_height;
        }
        $config_manip['master_dim'] = 'auto';
        if($fileData['file_ext'] == '.jpg' || $fileData['file_ext'] == '.jpeg'){
            $imgdata=exif_read_data($source_file, 'IFD0');    
        }
        $this->CI->load->library('image_lib', $config_manip);
        if (!$this->CI->image_lib->resize()) {
            // echo $this->CI->image_lib->display_errors();
        } else {
            $thumb_name = $fileData['raw_name'].'_thumb'.$fileData['file_ext'];
            $this->CI->image_lib->clear();
            $config=array();

            $config['image_library'] = 'gd2';
            $config['source_image'] = $target_path.$thumb_name;
            if(is_array($imgdata) && array_key_exists("Orientation",$imgdata) ){
                switch($imgdata['Orientation']) {
                    case 3:
                        $config['rotation_angle']='180';
                        break;
                    case 6:
                        $config['rotation_angle']='270';
                        break;
                    case 8:
                        $config['rotation_angle']='90';
                        break;
                }
                $this->CI->image_lib->initialize($config); 
                $this->CI->image_lib->rotate();
            }
           
        }

        $this->CI->image_lib->clear();
        return $thumb_name;
    }
   
}

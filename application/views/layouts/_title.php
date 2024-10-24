<title>
    <?php 
        if(ucfirst($this->uri->segment(0)) != null || ucfirst($this->uri->segment(1)) != null || ucfirst($this->uri->segment(2)) != null){
            echo SITE_NAME." - ".ucfirst($this->uri->segment(0)).ucfirst($this->uri->segment(2));
        }else{
            echo SITE_NAME;
        }            
    ?>
</title>


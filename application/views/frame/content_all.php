<?php

$data['title'] 		= $title;
$data['content']	= $content;
$data['info']		= (isset($info))?$info:'';
$this->load->view('frame/header', $data);
$this->load->view('frame/content', $data);
$this->load->view('frame/footer');
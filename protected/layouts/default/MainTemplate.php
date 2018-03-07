<?php

class MainTemplate extends TTemplateControl {
	public function doLogout ($sender,$param) {
        $this->Application->getModule('auth')->logout();
        $this->Response->reload();
    }
}
ZF2 Rest Client Demo Application Module
======================================

Introduction
------------
This is a ZF2 Rest Server Demo Application Module using Doctrine. 

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies:

    curl -s https://getcomposer.org/installer | php --

You would then invoke `composer` to install dependencies. Add to your composer.json

	"ledsinclouds/rest-client-demo": "dev-master"

Configuration
-------------

Once module installed, you could declare the module into your "config/application.config.php" by adding "LedsAlbum" & "Doctrine". 
	
        'Application',	
		'RestClientDemo'


# magento2-google-cloud-logging


This is a simple logging handler to view Magento2 logs in the Google Cloud Console.
Authentication for google logging should work out of the box on Google Compute Engine if vm is created with default permissions

Installing the Extension
--------------------------------------------------

1. Add this GitHub repository to your project as a composer repository

	composer config repositories.tajmahal vcs https://github.com/Tajmahal86/magento2-google-cloud-logging.git
	
	
2. Add the `tajmahal86/magento2-google-cloud-logging` composer package to your project

	composer require Tajmahal86/magento2-google-cloud-logging
	
3. Add Google ProjectId for authentication

	add following array to env.php 
	
		'gcplogging' => 
		  array (
			'proejctId' => 'my-projectid',
		  ),

4. Enable The Module

	php bin/magento module:enable Tajmahal86_Gcpconnector
        
	php bin/magento setup:upgrade


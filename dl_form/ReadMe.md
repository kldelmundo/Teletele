<h1>About The TelesCoop Online Forms Project</h1>
<p>This project is a small CodeIgniter Project that allows TelesCoop Members to download PDF version of loan applicatons forms.<p>
<br>
<p><h3>FEATURES</h3>

* Ability to Update PDF templates with Member Name and Employee ID
* Ability to create a unique form control number (aka DR) for each download
</p>

<h4>Files/Directories to integrate</h4>

* View Directory
  * loanforms.php - front-end
* Contoller
  * PForms.php - controls where page should go. It has the generatepdf() that 
* assets directory - contains form templates and the forms.config.json(responsible for controlling the location of text in pdf)
* Update Autoload.php 
  * $autoload['helper'] = array('url','form');
* Add the following to rountes.php  
  * $route['pforms/generatepdf'] = 'pforms/generatepdf';
  * $route['(:any)'] = 'pforms/view/$1';

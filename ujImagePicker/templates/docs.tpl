
<div class="container">
	<div class="row">
	
	<div class="page-header">
		<h1>ujImagePicker Documentation <small>An Easy Image Picker for Jamroom 5</small></h1>
	</div>

	<p>
		Documentation for the ujImagePicker module which provides an image picker as a custom form field for Jamroom 5.
	</p>

	<div class="page-header">
		<h1>Installation</h1>
	</div>

	<p>
		Upload the module to your server.
	</p>
	<p>
		Go to the module info tab in the admin control panel and enable it.
	</p>


	<div class="page-header">
		<h2>Add an image picker to a form using the Form Designer</h2>
	</div>
	<p>
		In this example we will add a field to allow the user to choose a kitten, as shown in the screenshot.
	</p>
	<img src="{$jamroom_url}/modules/ujImagePicker/screenshots/imagepicker-in-form-screenshot.jpg" alt="Screenshot of ujImagePicker being used in a form" title="Screenshot of ujImagePicker being used in a form">
	<ol>
		<li>Go to your form, then click on the Form Designer button.</li>
		<li>Add a new custom field named appropriately.</li>
		<li>In the field type dropdown select "imagepicker" or "imagepicker_multiple", check the box to allow both "create" and "update" and set the field to "active". See the screenshot below.</li>
		<li>You can add your images directly into the Options field (see the field's inline help for how to do that). For this example add the name of the test function: ujImagePicker_choose_a_kitten. To show the images with labels use ujImagePicker_choose_a_labelled_kitten. You can look at these test functions in include.php to see how to format your array of images.</li>
		<li>Click the View button to return to the profile form. You should now see the kittens to choose from.</li>
	</ol>
	<p> 
	    For both single and multiple selects your function should return an array like this:
	</p>
	<pre>
		array(
			'1'    =>    'http://placekitten.com/120/100',
			'2'    =>    'http://placekitten.com/160/100',
			'3'    =>    'http://placekitten.com/110/100',
			'4'    =>    'http://placekitten.com/130/100',
			'5'    =>    'http://placekitten.com/150/100'
		);
	</pre>
	<p> 
	    And if you need labels with the images format your array like this:
	</p>
	<pre>
		array(
			'cute'    =>    array('img_src'=>'http://placekitten.com/120/100','label'=>'cute kitten'),
			'cuter'   =>    array('img_src'=>'http://placekitten.com/160/100','label'=>'cuter kitten'),
			'cutest'  =>    array('img_src'=>'http://placekitten.com/110/100','label'=>'cutest kitten'),
			'yuck'    =>    array('img_src'=>'http://placekitten.com/130/100','label'=>'unpleasant kitten'),
			'sucker'  =>    array('img_src'=>'http://placekitten.com/150/100','label'=>'dog in disguise')
		);
	</pre>
	<p> 
	    If you have a directory of images, use this directory scanning function with the directory path from the site root:
	</p>
	<pre>
		ujImagePicker_get_images_from_dir(images/banksy/thumbs)
	</pre>
	<p> 
	    The image name (or names if using multiple select) will be saved to the db. You will want to make sure your images are of a suitable size to show in the form.
	</p>
	
	<p>If you want the select menu to show as well, make your array return this as one of the options"</p>
	<pre>'show_select'    =>    true,</pre>

	<p> 
	    And thats about all there is. Simple really.
	</p>
    
    <h3>Screenshot of Form Designer</h3>
	<img src="{$jamroom_url}/modules/ujImagePicker/screenshots/form-designer-screenshot.jpg" alt="Screenshot of an ujImagePicker field in Jamroom's form designer" title="Screenshot of an ujImagePicker field in Jamroom's Form Designer" title="An ujImagePicker field in Jamroom's Form Designer">

	<br><br><br><br>
	<table>
	  <tr>
		<td style="width:100%;vertical-align:top;padding:10px;border-right:1px solid #000000">

		  <p>The <b>ujImagePicker</b> module is licensed under the MIT License (MIT).</p>

		  <p>Jamroom license details: <a href="http://jamroom.net/" target="_blank">http://jamroom.net</a></p>
	  
		  <p>The image-picker jQuery plugin is also MIT licenced: <a href="https://github.com/rvera/image-picker/" target="_blank"></a> Copyright (c) 2013 Rodrigo Vera</p>

		  <h1>The MIT License (MIT)</h1>

		  <p>Copyright © 2013 <a href="http://ultrajam.net/" target="_blank">Ultrajam</a></p>
	  
		  <p>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:</p>
	  
		  <p>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.</p>
	  
		  <p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
	  
		</td>
	  </tr>
	</table>

	</div>
</div>


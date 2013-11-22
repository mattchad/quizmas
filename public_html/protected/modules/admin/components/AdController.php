<?php
	class AdController extends CController
	{
        public $pageTitle = 'CLPE Admin';
		public $layout='admin';
		public $text_formatting = "<p><a data-content=\"This is *bold text* - <strong>This is bold text</strong><br />
    This is _italic text_ - This is italic text<br />
    This is ^superscript text^ - <sup>This is superscript text</sup><br />
    This is ~subscript text~ - <sub>This is subscript text</sub><br />
    &quot;This is a link&quot;:http://example.com - <a href=&quot;http://example.com&quot;>This is a link</a><br />
    This is an &quot;email link&quot;:mailto:email@example.com - <a href=&quot;mailto:email@example.com&quot;>This is an email link</a><br />\" title=\"\" data-toggle=\"hover\" data-html=\"true\" class=\"more_popover\" href=\"#\" data-original-title=\"Text formatting options\">Text formatting options</a></p>";
	}
?>
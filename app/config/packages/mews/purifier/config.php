<?php

/*
 * This file is part of HTMLPurifier Bundle.
 * (c) 2012 Maxime Dizerens
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return array(
	'encoding' => 'UTF-8',
    'finalize' => true,
    'preload'  => false,
    'cachePath' => storage_path('purifier'),
    'settings' => array(
        'default' => array(
			'HTML.Doctype'             => 'HTML 4.01 Transitional',
			'HTML.Allowed'             => 'div,b,strong,i,em,a[href|title|target],ul,ol,li,p[style],br,span[style],img[width|height|alt|src],iframe[frameborder|marginheight|marginwidth|scrolling|src|height|width]',
			'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
			'Attr.AllowedFrameTargets' => '_blank',
			'AutoFormat.AutoParagraph' => true,
			'AutoFormat.RemoveEmpty'   => true,
			"HTML.SafeIframe" 		   => true,
			"URI.SafeIframeRegexp" 	   => "%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%",
        ),
    ),
);

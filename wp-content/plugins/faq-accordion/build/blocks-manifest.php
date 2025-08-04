<?php
// This file is generated. Do not modify it manually.
return array(
	'faq-accordion' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/faq-accordion',
		'version' => '0.1.0',
		'title' => 'FAQ Accordion',
		'category' => 'widgets',
		'icon' => 'list-view',
		'description' => 'Display FAQ section with expandable questions and answers, including automatic numbering and customizable heading.',
		'keywords' => array(
			'faq',
			'accordion',
			'questions',
			'answers'
		),
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => 'Frequently Asked Questions'
			),
			'faqItems' => array(
				'type' => 'array',
				'default' => array(
					array(
						'id' => 1,
						'question' => 'What is this?',
						'answer' => 'This is a sample FAQ item.'
					)
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'faq-accordion',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	)
);

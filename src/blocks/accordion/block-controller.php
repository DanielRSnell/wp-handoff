<?php
$context = Timber::context();
$context['block'] = $block;
$context['fields'] = get_fields();

Timber::render('@block/accordion/block.twig', $context);

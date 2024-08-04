<?php
require_once __DIR__."/config.php";
require_once __DIR__."/GoogleEmbedding.php";
$GoogleEmbedding = new GoogleEmbedding();
$documents = ['amor','amizade'];
$embeddings = $GoogleEmbedding->embed($documents, 'RETRIEVAL_DOCUMENT');
echo "<pre>";
print_r($embeddings);
echo "</pre>";
// Nesse exemplo é gerado embeddings para palavra "amor" e também para a palavra "amizade" em uma única request
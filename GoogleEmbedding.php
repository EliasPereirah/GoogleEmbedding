<?php
class GoogleEmbedding
{
    /**
     * @param array $documents Array com lista de texto a ser convertido em embedding
     * @param string $taskType - Se entendi bem se usa RETRIEVAL_QUERY quando performando uma busca
     * e usa-se RETRIEVAL_DOCUMENT quando gerando embeddings para armazenamento na base vetorial
    **/
    public function embed(array $documents, string $taskType, $model = GOOGLE_EMBEDDING_MODEL)
    {
        $total_documents = count($documents);
        $all_embeddings = [];
        $max = 100;
        while($total_documents > $max){
            // Por padrão a API aceita no máximo 100 documentos em batch
            // Caso seja recebido mais que isso de 100 documentos, será realizado outras mais requisições
           $doc = array_slice($documents, 0, $max);
           $new_embeddings = $this->embed($doc, $taskType, $model);
           $all_embeddings = array_merge($all_embeddings, $new_embeddings);
           $documents = array_slice($documents, $max);
           $total_documents = count($documents);
        }

        $google_api_key = GOOGLE_API_KEY;
        $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:batchEmbedContents?key=$google_api_key";
        $req_data = [];
        foreach ($documents as $text) {
            $req_data[] = [
                "model" => "models/$model",
                "taskType" => $taskType,
                "content" => [
                    "parts" => [
                        [
                            "text" => $text
                        ]
                    ],
                ]
            ];
        }
        $data = [ "requests" => [$req_data]];
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response)->embeddings ?? [];
        if(count($data) === 0){
            print_r($response);
        }
        foreach ($data as $item) {
            // formato aceito pela ChromaDB
            $all_embeddings[] = $item->values;
        }
        return $all_embeddings;
    }
}
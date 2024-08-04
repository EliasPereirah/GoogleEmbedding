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
        return json_decode($response);
    }
}
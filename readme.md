# Google Embedding com o Modelo text-embedding-004

## Geração de Embeddings gratuitos com Google AI

Para gerar embeddings gratuitamente, siga estes passos:

1. Use uma conta Google que não esteja associada a uma conta de faturamento no Google Cloud.
2. Gere sua chave API gratuitamente em: [https://aistudio.google.com/app/apikey](https://aistudio.google.com/app/apikey)

## Exemplo de geração de Embedding em PHP

```php
require_once __DIR__."/config.php";
require_once __DIR__."/GoogleEmbedding.php";

$GoogleEmbedding = new GoogleEmbedding();
$documents = ['paz', 'terra'];
$embeddings = $GoogleEmbedding->embed($documents, 'RETRIEVAL_DOCUMENT');

echo "<pre>";
print_r($embeddings);
echo "</pre>";
```

Neste exemplo, são gerados embeddings para as palavras "paz" e "terra" em uma única requisição,
veja que nesse exemplo "RETRIEVAL_DOCUMENT" foi passado como segundo argumento para o método embed.
Esse argumento(se entendi bem) é usado quando se está gerando embeddings para serem armazenados na base de dados para 
serem posteriormente pesquisados, use "RETRIEVAL_QUERY" quando for gerar embedding para um termo de busca. 
Veja outras opções aqui: https://ai.google.dev/api/embeddings#v1beta.TaskType

## O que são Embeddings?

Embeddings são representações numéricas de palavras ou textos que capturam seus significados semânticos. Em termos simples:

- Transformam palavras e textos em listas de números.
- Palavras e textos com significados similares terão representações numéricas parecidas.

## Para que servem os Embeddings?

1. **Busca de textos similares**:
  - Funcionam como um super buscador que entende o significado semântico da sua busca.
  - Exemplo: Uma busca por "animal doméstico" pode encontrar resultados relacionados a "gato de estimação" ou "bicho de estimação".

2. **Classificação de textos**:
  - Podem ser usados para categorizar textos (ex: positivo/negativo).

3. **Agrupamento de textos similares**:
  - Identificam textos sobre o mesmo assunto, mesmo que usem palavras diferentes.

## Como funciona na prática?

Exemplo de uso em um sistema de busca:

1. O conteúdo de texto é transformado em embeddings.
  - Ex: "Aja como se a máxima de tua ação devesse tornar-se, através da tua vontade, uma lei universal." → [[0,1,2,3], [0,1,2,3],...]

2. Os embeddings são armazenados em uma base de dados vetorial (ex: ChromaDB).

3. Para realizar uma busca:
  - O termo de busca é transformado em embedding.
  - Ex: "legislatura cósmica" → [[4,3,2,1], [4,3,2,1], ...]
  - Este embedding é comparado com os embeddings armazenados na base de dados.

## Bases de Dados Vetoriais

Existem várias opções de bases de dados vetoriais, como:
- Chroma (open source)
- Pinecone
- Weaviate
- Milvus

Escolha a que melhor se adapta às suas necessidades de projeto e escala.
# Links úteis:
https://colab.research.google.com/github/google-gemini/cookbook/blob/main/quickstarts/rest/Embeddings_REST.ipynb

https://ai.google.dev/api/embeddings

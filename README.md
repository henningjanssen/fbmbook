# fbmbook
The purpose of this project is to generate a printable PDF and and structured directory containing media for GDPR exports of facebook messenger chats.

## Building the document

We assume you already have `messages_1.json` files in the folder `data/`

```
# Create the database schema
./bin/doctrine orm:schema-tool:create
# Fill the database
./bin/fbmbook preprocess data/
# Build latex-document's data
./bin/fbmbook to-latex > data/content.tex
# Build the pdf
latexmk -pdf -pvc -lualatex book.tex 
```

#!/bin/bash
docker run --rm -v "$(pwd):/data" "phpdoc/phpdoc:3" && php -S localhost:3000 -t docs

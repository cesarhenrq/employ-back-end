# employ-back-end
Sistema de back-end para lidar com as interações de uma aplicação de gerenciamento de tarefas de um usuário com um banco de dados.
## Pré-requisitos
Para esse projeto funcionar no seu ambiente, será necessário ter o php instalado nela. Como se trata de um processidimento muito grande, vou deixar um link que explica, de forma didática, o processo: https://blog.schoolofnet.com/como-instalar-o-php-no-windows-do-jeito-certo-e-usar-o-servidor-embutido/
Também será necessário fazer uso do Apache pois todo o projeto está configurado para funcionar em conjunto com ele. Segue um link de um vídeo que ensina como fazer esse processo no windows 10: https://www.youtube.com/watch?v=Y60Vvd4lhtg
## Implantação
O sistema está depositado na heroku e dentro do projeto tá tem dois arquivos que fazem a configuração para ele funcionar lá: o composer.json, que informa a heroku que se trata de um projeto php e o Procfile.txt, que informa que o servidor a ser utilizado deve ser o Apache 2 (Por padrão a heroku utiliza o Nginx). Você pode utilizar o sistema em produção através do seguinte link: https://employ-back-end-1fa428ae58ff.herokuapp.com/
## Construído com
*PHP: PHP é uma linguagem de script do tipo server-side com diversos propósitos.

export ZSH=$HOME/.oh-my-zsh

ZSH_THEME="jnrowe"

plugins=(git symfony2 composer)

export PATH=$HOME/bin:/usr/local/bin:$PATH

source $ZSH/oh-my-zsh.sh

cd /app/api

alias cc="php /app/bin/console c:cl"
alias dsu="php /app/bin/console d:s:u --force"
alias dfl="php /app/bin/console d:f:l"
alias dsv="php /app/bin/console d:s:v"
alias rdb="php /app/bin/console d:d:d --force && \
            php /app/bin/console d:d:c && \
            php /app/bin/console d:s:u --force && \
            php /app/bin/console hautelook_alice:doctrine:fixtures:load"
alias t="/app/vendor/bin/phpunit"

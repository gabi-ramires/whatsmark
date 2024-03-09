var app = new Vue({
    el: '#vue',
    data: {
        temPlanoContratado: ''
    },
    methods: {
        temPlano: async function () {
            try {
                const response = await fetch('/verificaSeTemPlano/a1d0c6e83f027327d8461063f4ac58a6', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error('Erro ao obter os envios');
                }
                const temPlano = await response.json();

                if (temPlano.success) {
                    this.temPlanoContratado = true;
                }
            } catch (error) {
                temPlano = error.message;
            }
        }
    },
    mounted: function(){
            try {
                this.temPlano();
            } catch (error) {
                console.error("Erro durante a inicialização");
            }
        },
});
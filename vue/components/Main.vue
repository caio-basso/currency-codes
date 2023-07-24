<template>
    <div class="mt-28 w-screen flex absolute items-center justify-center">
        <div class="w-2/3">
            <div class="flex">
                <v-text-field label="Código(s) ou número(s) que deseja buscar" v-model="inputValue"></v-text-field>
                <v-btn class="mt-3 ml-4" color="primary" @click="makeRequest">
                    Buscar  
                </v-btn>
            </div>
            <v-alert type="error" v-if="errorMessage">Moeda não encontrada.</v-alert>
            <div v-if="data">
                <v-sheet class="mx-auto" elevation="1" max-width="1500" height="400" color="accent" rounded>
                    <v-slide-group class="pa-4" show-arrows>
                        <v-slide-group-item v-for="item in data" :key="item">
                            <Card 
                                :currency="item"
                            />
                        </v-slide-group-item>
                    </v-slide-group>
                </v-sheet>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inputValue: '',
            data: null,
            errorMessage: false,
        };
    },
    methods: {
        async makeRequest() {
            try {
                if (this.inputValue.length == 0) {
                    this.data = null;
                } else {
                    const body_array = this.inputValue.split(/[ ,]+/);
                    const response = await fetch('http://localhost/api/currency', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ "list": body_array }), 
                    })
                    if(!response.ok){
                        if (response.status === 404) {
                            this.errorMessage = true;
                        }
                    } else {
                        this.errorMessage = false;
                        this.data = await response.json();
                    }
                    
                    console.log(this.data);
                }
            } catch {
                console.log(error);
            }
        },
    }
};
</script>
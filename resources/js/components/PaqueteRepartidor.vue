<template>
    <div>
        <div class="card mb-1 card-outline card-danger">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start align-items-center">
                        <h5 class="text-secondary">Llenar datos de carga de paquetes</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <template>
                    <v-stepper v-model="e1">
                        <v-stepper-header>
                            <v-stepper-step :complete="e1 > 1" step="1">
                                Name of step 1
                            </v-stepper-step>
                            <v-divider></v-divider>
                            <v-stepper-step :complete="e1 > 2" step="2">
                                Name of step 2
                            </v-stepper-step>
                            <v-divider></v-divider>
                            <v-stepper-step step="3">
                                Name of step 3
                            </v-stepper-step>
                        </v-stepper-header>

                        <v-stepper-items>
                            <v-stepper-content step="1">
                                <v-card class="mb-12" color="grey lighten-1" height="200px">
                                    
                                </v-card>

                               
                            </v-stepper-content>            
                        </v-stepper-items>
                    </v-stepper>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                e1: 1,
            }
        },
    }
</script>
<template>
    <div id="app">
        <div class="container">
           <div class="form-row">
               <div class="form-group col-md-4">
                    <label for="recipient-name" class="col-form-label">Codigo de barras escaneado</label>
                    <input class="form-control" :class="['input', ($v.form.username.$error) ? 'is-danger' : '']" 
                        type="number" v-model="form.username">
                        <p v-if="$v.form.username.$error" class="help is-danger">This username is invalid</p>
               </div>
           </div>
        </div>
    </div>
</template>

<script>
    import { validationMixin  } from 'vuelidate'
    import { required,  email  } from 'vuelidate/lib/validators'

    export default {
        props: ['clickedNext', 'currentStep'],
        mixins: [validationMixin],
        data() {
            return {
                form: {
                    username: ''
                }
            }
        },
        validations: {
            form: {
                username: {
                    required
                }
            }
        },
        watch: {
            $v: {
                handler: function (val) {
                    if (!val.$invalid) {
                        this.$emit('can-continue', {
                            value: true
                        });
                    } else {
                        this.$emit('can-continue', {
                            value: false
                        });
                        setTimeout(() => {
                            this.$emit('change-next', {
                                nextBtnValue: false
                            });
                        },400)
                    }
                },
                deep: true
            },

            clickedNext(val) {
                console.log(val);
                if (val === true) {
                    this.$v.form.$touch();
                }
            }
        },
        mounted() {
            if (!this.$v.$invalid) {
                this.$emit('can-continue', {
                    value: true
                });
            } else {
                this.$emit('can-continue', {
                    value: false
                });
            }
        }
    }

</script>

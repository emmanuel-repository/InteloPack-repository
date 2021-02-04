<template>
    <div >
       
  <section class="section" style="padding-top: .5rem">
            <div class="container">
                <div class="columns">
                    <div class="column is-8 is-offset-2">
                        <horizontal-stepper :steps="demoSteps" 
                            @completed-step="completeStep" :top-buttons="true"  
                            @active-step="isStepActive" @stepper-finished="alert"></horizontal-stepper>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
    import HorizontalStepper from './src/HorizontalStepper.vue';

    import StepOne from './steps/Escaner.vue';
    import StepTwo from './steps/Cliente.vue';

    const teamUrl = 'https://github.com/PygmySlowLoris';
    const repoUrl = 'https://github.com/PygmySlowLoris/vue-stepper';

    export default {
        name: 'app',
        components: {
            HorizontalStepper
        },
        data() {
            return {
                repoUrl: repoUrl,
                teamUrl: teamUrl,
                demoSteps: [{
                        icon: 'qr_code',
                        name: 'first',
                        title: 'Escaner',
                        subtitle: 'Paso 1',
                        component: StepOne,
                        completed: false

                    },
                    {
                        icon: 'report_problem',
                        name: 'second',
                        title: 'Sample title 2',
                        subtitle: 'Subtitle sample',
                        component: StepTwo,
                        completed: false
                    },
                    {
                        icon: 'announcement',
                        name: 'third',
                        title: 'Sample title 3',
                        subtitle: 'Subtitle sample',
                        component: StepOne,
                        completed: false
                    }
                ],
                activeStep: 0
            }
        },
        computed: {},
        methods: {
            completeStep(payload) {
                this.demoSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        step.completed = true;
                    }
                })
            },
            isStepActive(payload) {
                this.demoSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        if (step.completed === true) {
                            step.completed = false;
                        }
                    }
                })
            },
            alert(payload) {
                console.log('hola mundo')
            }
        }
    }
</script>
<style>
    .input.is-danger,
    .textarea.is-danger {
        border-color: #ff3860;
    }

    .select.is-danger select {
        border-color: #ff3860;
    }

    .help.is-danger {
        color: #ff3860;
    }

    .notification.is-danger {
        background-color: #ff3860;
        color: #fff;
    }

    .tag.is-danger {
        background-color: #ff3860;
        color: #fff;
    }

    .message.is-danger {
        background-color: #fff5f7;
    }

    .message.is-danger .message-header {
        background-color: #ff3860;
        color: #fff;
    }

    .message.is-danger .message-body {
        border-color: #ff3860;
        color: #cd0930;
    }


    .hero.is-danger {
        background-color: #ff3860;
        color: #fff;
    }

    .hero.is-danger a:not(.button),
    .hero.is-danger strong {
        color: inherit;
    }

    .hero.is-danger .title {
        color: #fff;
    }

    .hero.is-danger .subtitle {
        color: rgba(255, 255, 255, 0.9);
    }

    .hero.is-danger .subtitle a:not(.button),
    .hero.is-danger .subtitle strong {
        color: #fff;
    }

    .hero.is-danger .nav {
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    @media screen and (max-width: 768px) {
        .hero.is-danger .nav-menu {
            background-color: #ff3860;
        }
    }

    .hero.is-danger a.nav-item,
    .hero.is-danger .nav-item a:not(.button) {
        color: rgba(255, 255, 255, 0.7);
    }

    .hero.is-danger a.nav-item:hover,
    .hero.is-danger a.nav-item.is-active,
    .hero.is-danger .nav-item a:not(.button):hover,
    .hero.is-danger .nav-item a:not(.button).is-active {
        color: #fff;
    }

    .hero.is-danger .tabs a {
        color: #fff;
        opacity: 0.9;
    }

    .hero.is-danger .tabs a:hover {
        opacity: 1;
    }

    .hero.is-danger .tabs li.is-active a {
        opacity: 1;
    }

    .hero.is-danger .tabs.is-boxed a,
    .hero.is-danger .tabs.is-toggle a {
        color: #fff;
    }

    .hero.is-danger .tabs.is-boxed a:hover,
    .hero.is-danger .tabs.is-toggle a:hover {
        background-color: rgba(10, 10, 10, 0.1);
    }

    .hero.is-danger .tabs.is-boxed li.is-active a,
    .hero.is-danger .tabs.is-boxed li.is-active a:hover,
    .hero.is-danger .tabs.is-toggle li.is-active a,
    .hero.is-danger .tabs.is-toggle li.is-active a:hover {
        background-color: #fff;
        border-color: #fff;
        color: #ff3860;
    }

    .hero.is-danger.is-bold {
        background-image: -webkit-linear-gradient(309deg, #ff0561 0%, #ff3860 71%, #ff5257 100%);
        background-image: linear-gradient(141deg, #ff0561 0%, #ff3860 71%, #ff5257 100%);
    }

    @media screen and (max-width: 768px) {
        .hero.is-danger.is-bold .nav-menu {
            background-image: -webkit-linear-gradient(309deg, #ff0561 0%, #ff3860 71%, #ff5257 100%);
            background-image: linear-gradient(141deg, #ff0561 0%, #ff3860 71%, #ff5257 100%);
        }
    }

    @media screen and (max-width: 768px) {
        .hero.is-danger .nav-toggle span {
            background-color: #fff;
        }

        .hero.is-danger .nav-toggle:hover {
            background-color: rgba(10, 10, 10, 0.1);
        }

        .hero.is-danger .nav-toggle.is-active span {
            background-color: #fff;
        }

        .hero.is-danger .nav-menu .nav-item {
            border-top-color: rgba(255, 255, 255, 0.2);
        }
    }
</style>
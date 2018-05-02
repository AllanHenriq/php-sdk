<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Card Details</div>
                    <div class="card-body">
                        <ul id="v-for-object" class="demo">
                          <li v-for="value in card">
                            {{ value }}
                          </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import card from '../resources/cardWikiResource.js'
    export default {
        data () {
            return {
                card: {
                    firstName: 'John',
                    lastName: 'Doe',
                    age: 30
                }
            }
        },
        mounted () {
            console.log('here')
            this.getCard()
        },
        methods: {
            getCard: function () {
                card.show('RedElementalBlast')
                    .then((response) => {
                        this.card = response
                    })
            }
        }
    }
</script>

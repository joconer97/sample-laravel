<template>
  <div>
     <vue-stripe-checkout
      ref="checkoutRef"
      :image="image"
      :name="name"
      :description="description"
      :currency="currency"
      :amount="amount"
      @done="done"
      @opened="opened"
      @closed="closed"
      @canceled="canceled"
    ></vue-stripe-checkout>
    <button @click="checkout">
      Checkout
    </button>

    <b-card
      title="Card Title"
      img-src="https://picsum.photos/600/300/?image=25"
      img-alt="Image"
      img-top
      tag="article"
      style="max-width: 20rem;"
      class="mb-2"
    >
      <b-card-text>
        Some quick example text to build on the card title and make up the bulk of the card's content.
      </b-card-text>

      <b-button
        href="#"
        variant="primary"
      >
        Go somewhere
      </b-button>
    </b-card>
  </div>
</template>
<script>
export default {
  data () {
    return {
      image      : 'https://i.imgur.com/HhqxVCW.jpg',
      name       : 'Oragon Booking Resort',
      description: 'We are happy doing business with you!',
      currency   : 'PHP',
      amount     : 99999,
    }
  },
  methods: {
    async checkout () {
      // token - is the token object
      // args - is an object containing the billing and shipping address if enabled
      const { token, arguments_ } = await this.$refs.checkoutRef.open()
    },
    done ({ token, arguments_ }) {
      // token - is the token object
      // args - is an object containing the billing and shipping address if enabled
      // do stuff...
      console.log(token)
      console.log(token === undefined)
    },
    opened () {
      // do stuff
    },
    closed () {
      // do stuff
    },
    canceled () {
      // do stuff
    },
  },
}
</script>

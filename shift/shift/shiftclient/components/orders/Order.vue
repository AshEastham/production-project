<template>
    <tr>
        <td>
        #{{ order.id }}
        </td>
        <td>
            {{ order.created_at }}
        </td>
        <td>
            <div v-for="variation in products" :key="variation.id">
                <nuxt-link
                    :to="{
                        name: 'products-slug',
                        params: {
                            slug: variation.product.slug
                        }
                    }"
                >
                    {{ variation.product.name }} ({{ variation.name }})
                </nuxt-link>
            </div>
            <template v-if="moreProducts > 0">
            and {{ moreProducts }} more
            </template>
        </td>
        <td>{{ order.subtotal }}</td>
        <td>
            <component :is="order.status" />
        </td>
    </tr>
</template>

<script>
    import OrderStatusPaymentFailed from '@/components/orders/statuses/OrderStatus-payment_failed'
    import OrderStatusPending from '@/components/orders/statuses/OrderStatus-pending'

    export default {
        components: {
            'payment_failed': OrderStatusPaymentFailed,
            'pending': OrderStatusPending
        },

        data () {
            return {
                maxProducts: 2,
                statusClasses: {
                    'is-success': this.order.status === 'complete',
                    'is-info': this.order.status === 'processing' || this.order.status === 'pending',
                    'is-danger': this.order.status === 'payment_failed',
                }
            }
        },

        props: {
            order: {
                required: true,
                type: Object
            }
        },

        computed: {
            products () {
                return this.order.products.slice(0, this.maxProducts)
            },

            moreProducts () {
                return this.order.products.length - this.maxProducts
            }
        }
    }
</script>

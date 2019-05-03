export default {
    methods: {
        updateOrder: function(orderKey) {
            /**
             * Ändert die Richtung in der Sortiert wird
             */
            if (this.orderBy === orderKey) {
                /**
                 * Ändert richtung absteigend
                 */
                if (this.orderDirection === 'asc') {
                    this.orderDirection = 'desc'
                } else {
                    this.orderDirection = 'asc'
                }
            } else {
                /**
                 * Ändert den Schlüsselwert nachdem sortier wird
                 */
                this.orderBy = orderKey
                this.orderDirection = 'desc'
            }
        }
    }
}

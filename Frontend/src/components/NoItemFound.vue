<template>
    <div class="list">
        <div>
            <h2>Es wurde noch kein {{ itemDefinition }} angelegt</h2>
            <RouterLink :to="{ name: goto }" tag="a">
                <span>Klicken Sie hier um einen neuen Eintrag anzulegen.</span>
            </RouterLink>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        itemDefinition: {
            type: String,
            default: 'Eintrag'
        },
        goto: {
            type: String,
            required: true
        }
    }
}
</script>

<style src="@/assets/scss/components/List.scss" lang="scss" scoped></style>
<style lang="scss" src="@/components/NoItemFound.scss" scoped></style>

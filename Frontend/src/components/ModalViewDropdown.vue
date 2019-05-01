<template>
  <div class="modal-view-input">
    <title>{{ name }}</title>
    <select
      :name="name"
      v-bind="$attrs"
      @input="$emit('input', $event.target.value)"
      v-validate="validation"
    >
      <option value="-1">Kein Lager</option>
      <option v-for="l of lager" :value="l.id">{{l.id + '. ' + l.bezeichnung}}</option>
    </select>
    <span class="error">{{ errors.first(name) }}</span>
  </div>
</template>

<script>
export default {
    computed: {
        lager: function() {
            return this.$store.getters[this.getter]
        }
    },
    props: {
        name: {
            type: String,
            required: true
        },
        validation: {
            type: String,
            default: ''
        },
        getter: {
            type: String,
            required: true
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalViewInput.scss" scoped></style>

<template>
  <div>
    <slot :handleSubmit="handleSubmit"></slot>
  </div>
</template>

<script>

export default {
  name: "Vuemik",
  props: {
    onSubmit: { type: Function, required: true },
    initialValues: { type: Object },
  },
  data: () => ({ values: {}}),
  mounted() {
    this.values = this.initialValues;
  },
  provide() {
    return {
      vuemik: {
        values: this.initialValues,
        change: this.handleChange,
      },
    };
  },
  methods: {
    getData(e){
      if (e.target.option !== undefined) {
        const optionSelect = e.target.options[e.target.selectedIndex];
        return optionSelect.value;
      }
      if (e.target.type !== undefined && e.target.type !== 'textarea') {
        return e.target.type === 'checkbox' ? e.target.checked : e.target.value;
      }
      return e.target.value;
    },
    handleChange(e) {
      this.setValues({ [e.target.name]: this.getData(e) });
    },
    setValues(values) {
      Object.entries(values).forEach(([key, val]) => {
        this.values[key] = val;
      });
    },
    handleSubmit() {
      this.onSubmit(this.values);
    }
  },
}
</script>
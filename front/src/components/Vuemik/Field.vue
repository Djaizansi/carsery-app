<template>
  <component
      :ref="name"
      :is="component"
      :name="name"
      @input="vuemik.change"
      :value="vuemik.values[name]"
      :type="type"
  >
    <slot></slot>
  </component>
</template>

<script>
export default {
  name: "Field",
  inject: ["vuemik"],
  mounted() {
    this.setInitialValue();
  },
  props: {
    component: { type: [Object, String], required: true },
    name: { type: String, required: true },
    type: { type: String }
  },
  methods: {
    setInitialValue() {
      const component = this.$refs[this.name];
      const data = this.vuemik.values[this.name];
      if(data !== undefined){
        if(this.type === "checkbox"){
          component.checked = data;
        }

        if(this.type === "radio" && data === component.value){
          component.checked = true;
        }

        if(this.component === "textarea"){
          component.value = data;
        }else if(this.component === "select"){
          Object.values(component.options).map((option,index) => component.selectedIndex = option.value == data && index);
        }
      }
    }
  }
};
</script>
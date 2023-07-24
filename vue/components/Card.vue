<template>
  <v-card :class="['ma-4']" height="300" width="200">
    <v-card-item>
      <v-card-title>{{currency[0].code}}</v-card-title>

      <v-card-subtitle>
        <span class="me-1">{{currency[0].currency}}</span>
      </v-card-subtitle>
    </v-card-item>

    <v-card-text>
      <v-row align="center" class="mx-0">
        <div class="text-grey">
          <div>Número: {{currency[0].number}}</div>
        </div>
      </v-row>
      <v-row align="center" class="mx-0">
        <div>Casas Decimais: {{currency[0].decimal}}</div>
      </v-row>
    </v-card-text>

    <v-divider class="mx-4 mb-1"></v-divider>

    <div class="px-4">
      <v-virtual-scroll
        :items="currency[0].currency_locations"
        height="150"
        item-height="40"
      >
        <template v-slot:default="{ item }">
          <v-list-item>
            <v-list-item-title>{{ item.location }}</v-list-item-title>
          </v-list-item>
        </template>
      </v-virtual-scroll>



    </div>
  </v-card>
</template>

<script>
  export default {
    props: {
      currency: Array
    }
  }
</script>
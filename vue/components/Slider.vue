<template>
    <v-sheet class="mx-auto" elevation="1" max-width="1000" height="400" color="accent" rounded>
        <v-slide-group v-model="model" class="pa-4" show-arrows>
            <v-slide-group-item v-for="n in 17" :key="n">
                <Card decimals="2"/>
            </v-slide-group-item>
        </v-slide-group>
    </v-sheet>
</template>

<script>
export default {
    data: () => ({
        model: null,
    }),
}
</script>
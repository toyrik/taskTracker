<template>
    <v-row justify="center">
        <v-dialog
            v-bind="dialog"
            persistent
            width="1280"
        >
           <v-card>
               <v-card-title>
                   <span class="text-h5" v-if="formData.id">Edit {{ moduleName }}</span>
                   <span class="text-h5" v-else>Add {{ moduleName }}</span>
               </v-card-title>
               <v-card-text>

               </v-card-text>
           </v-card>
        </v-dialog>
    </v-row>
</template>

<script setup>
import { ref } from "vue"

const { moduleName, userRef, dialog, formData } = defineProps({
    moduleName: String,
    userRef: String,
    dialog: Boolean,
    formData: Object,
    // apiStatusData: Object,
    // apiUserNameData: Object,
})
</script>

<style scoped>

</style>

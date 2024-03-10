<template>
    <h2>{{ moduleName }}
        <span>
            <v-btn type="submit"
               style="float:right;"
               :loading="loading"
               size="small"
               color="warning"
               @click="openModal()">
                + Add
            </v-btn>
        </span>
    </h2>
    <EasyDataTable
        v-model:server-options="serverOptions"
        :server-items-length="serverItemsLength"
        :loading="loading"
        :headers="headers"
        :items="apiData"
        :rows-items="rowItems"
        show-index
    >
        <template #item-operation="item">
            <div class="operation-wrapper">
                <v-btn
                    class="ma-2"
                    color="success"
                    size="x-small"
                    @click="editData(item.id, item.index)"
                >
                    Edit
                    <v-icon
                        end
                        icon="mdi-pencil"
                    ></v-icon>
                </v-btn>
                <v-btn
                    class="ma-2"
                    color="error"
                    size="x-small"
                    @click="deleteData(item.id, item.index)"
                >
                    Delete
                    <v-icon
                        end
                        icon="mdi-delete"
                    ></v-icon>
                </v-btn>
            </div>
        </template>
    </EasyDataTable>
    <v-form @submit.prevent="submitForm" ref="formRef">
        <TaskFormModal
            :dialog="dialog"
            :userRef="userRef"
            :formData="formData"
            :moduleName="moduleName"
        />
    </v-form>
</template>

<script setup>
import { ref, onMounted, watch } from "vue"
import TaskFormModal from '../components/Task/TaskFormModal.vue'
import store from "../store";
import { useRouter } from 'vue-router'


const emit = defineEmits(['openModal', 'closeModal', 'submitForm', 'inputChange', 'selectChange'])

const router = useRouter()

const moduleName = 'Task List'

const apiData =ref([])
const searchValue = ref('')
const statusRef = ref('')
const userRef = ref('')

const loading = ref(false)
const serverItemsLength = ref(0)
const rowItems = [10]

const dialog = ref(false)
const formData = ref({
    id: '',
    start_day: '',
    end_day: '',
    status: 'Created',
    user_id: '',
})

const formRef = ref(null)

const serverOptions = ref({
    page: 1,
    rowsPerPage: 10,
    sortBy: 'id',
    sortType: 'desc',
})

const headers = [
    // { text: "Id", value: "id" },
    { text: "Task ID", value: "id" },
    { text: "Apointed to", value: "user.full_name" },
    { text: "Start Day", value: "start_day" },
    { text: "End Day", value: "end_day" },
    { text: "Status", value: "status" },
    { text: "Operation", value: "operation" },
]

const fetchData = async () => {
    loading.value = true
    await axios({
        method: 'GET',
        url: 'api/tasks?page='+serverOptions.value.page+'&search='+searchValue.value+'&status='+statusRef.value,
        data: {}
    }).then(res => {
        apiData.value = res.data.data
        serverItemsLength.value = res.data.meta.total
    }).catch(err => {
        console.log(err)
    })
    loading.value = false
}

const openModal = () => {
    dialog.value = true
}

const closeModal = () => {
    clearForm()
    dialog.value = false
    userRef.value = ''
}

const submitForm = async () => {
    //todo
}

const editData = (id) => {
    const filteredData = apiData.value.filter(f => f.id === id)
    console.log(filteredData)
    formData.value = filteredData[0]
    userRef.value = filteredData[0].user.full_name
    openModal()
}

const clearForm = () => {
    formData.value = {
        ticket_id: '',
        link: '',
        start_day: '',
        end_day: '',
        proposed_completion_day: '',
        status: 'Pending',
        user_id: '',
        approver_id: '',
        verify_status: 'Not Approved',
    }
}

const deleteData = async (id) => {
    if(confirm('are you sure?')){
        await axios({
            method: 'DELETE',
            url: '/api/tasks/'+id,
            data: {}
        }).then(res => {
            let newData = apiData.value.filter(item => item.id != id);
            apiData.value = newData
            store.dispatch('UPDATE_ALERT', {
                value: true,
                type: 'success',
                text: res?.data?.message ? res?.data?.message : 'Operation Successful',
            })
        }).catch(err => {
            const alertMsg = err?.response?.data?.message ? err?.response?.data?.message : 'Operation Failed'
            store.dispatch('UPDATE_ALERT', {
                value: true,
                type: 'error',
                text: alertMsg,
            })
            console.log(err)
        })
    }
}

onMounted(() => {
    fetchData()
})

</script>

<style scoped>

</style>

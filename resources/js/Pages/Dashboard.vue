<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from '@/Components/Modal.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { nextTick, ref } from 'vue';

const confirmingCompanyAddition = ref(false);
const companyAddSuccess = ref(false);
const nameInput = ref('');
const innInput = ref('');

defineProps({
    companies: Object,
    message: String
});

const form = useForm({
    name: '',
    inn: '',
    info: '',
    ceo: '',
    address: '',
    phone: '',
});

const confirmCompanyAddition = () => {
    confirmingCompanyAddition.value = true;
    
    nextTick(() => nameInput.value.focus());
};

const addCompany = () => {
    form.post(route('companies.store'), {
        preserveScroll: true,
        onSuccess: () => {
        closeModal();
        companyAddSuccess.value = true;
            setTimeout(() => {
                companyAddSuccess.value = false;
            }, 5000);
        },
        onError: () => {
            if (form.errors.name) {
                form.reset('name');
                    nameInput.value.focus();
            }
            if (form.errors.inn) {
                form.reset('inn');
                    innInput.value.focus();
            }
        },
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingCompanyAddition.value = false;

    form.reset();
};
</script>

<template>
    <Head title="Company" />

    <AuthenticatedLayout>
        <div v-if="companyAddSuccess" class="alert-box bg-green-100 text-green-900  max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 rounded fixed top-0 right-0" role="alert">
            <span class="block sm:inline">{{ $page.props.flash.message }}</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 lg:gap-8 max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
            <div v-for="company in companies" :key="company.id" class="max-w-7xl p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <Link :href="route('comments.show', {'id': company.id})">
                    <div class="text-xl font-semibold text-gray-900 dark:text-white">{{ company.name }}</div>
                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{ company.info }}</p>
                </Link>
            </div>
            <div v-if="!companies || companies === 0">
                <h2>Нет компаний</h2>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 sticky bottom-5 flex justify-center">
            <PrimaryButton @click="confirmCompanyAddition">
                Добавить компанию
            </PrimaryButton>
        </div>
        <Modal :show="confirmingCompanyAddition" @close="closeModal">
            <div class="p-6">
                <div>
                    <InputLabel for="name" value="Название компании" />
                    <TextInput
                        id="name"
                        ref="nameInput"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        autocomplete="name"
                        placeholder="Название компании"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="inn" value="ИНН" />
                    <TextInput
                        id="inn"
                        ref="innInput"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.inn"
                        autocomplete="inn"
                        placeholder="ИНН"
                    />
                    <InputError class="mt-2" :message="form.errors.inn" />
                </div>

                <div>
                    <InputLabel for="info" value="Общая информация" />
                    <TextInput
                        id="info"
                        ref="infoInput"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.info"
                        placeholder="Общая информация"
                    />
                    <InputError class="mt-2" :message="form.errors.info" />
                </div>

                <div>
                    <InputLabel for="ceo" value="Генеральный директор" />
                    <TextInput
                        id="ceo"
                        ref="ceoInput"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.ceo"
                        placeholder="Генеральный директор"
                    />
                    <InputError class="mt-2" :message="form.errors.ceo" />
                </div>

                <div>
                    <InputLabel for="address" value="Адрес" />
                    <TextInput
                        id="address"
                        ref="addressInput"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.address"
                        placeholder="Адрес"
                    />
                    <InputError class="mt-2" :message="form.errors.address" />
                </div>

                <div>
                    <InputLabel for="phone" value="Телефон" />
                    <TextInput
                        id="phone"
                        ref="phoneInput"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                        placeholder="Телефон"
                    />
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>

                <div class="flex justify-end mt-4">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton 
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="addCompany">
                        Добавить
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

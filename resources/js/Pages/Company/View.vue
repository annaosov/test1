<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseAccordian from "@/Components/BaseAccordion.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm , usePage, Link} from "@inertiajs/vue3";
import { ref } from 'vue';

const open = ref(false);
const commentAddSuccess = ref(false);

defineProps({
    company: Object,
    comments: Object,
});

const props = usePage().props;

const accordions = ref([
    {
        field_name: "general",   
        title: props.company.name,
        text: ""
    },
    {
        field_name: "name",   
        title: "Название",
        text: props.company.name
    },
    {
        field_name: "inn",   
        title: "ИНН",
        text: props.company.inn
    },
    {
        field_name: "info",   
        title: "Общая информация",
        text: props.company.info
    },
    {
        field_name: "CEO",   
        title: "Генеральный директор",
        text: props.company.CEO
    },
    {
        field_name: "address",   
        title: "Адрес",
        text: props.company.address
    },
    {
        field_name: "phone",   
        title: "Телефон",
        text: props.company.phone
    },
]);

const form = useForm({
    companyId: props.company.id,
    userId: props.auth.user.id,
    general: '',
    name: '',
    inn: '',
    info: '',
    CEO: '',
    address: '',
    phone: '',
});

const addComment = () => {
    form.post(route('comments.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            commentAddSuccess.value = true;
            setTimeout(() => {
                commentAddSuccess.value = false;
            }, 5000);
        },
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head :title="company.name" />
    <AuthenticatedLayout>
        <div v-if="commentAddSuccess" class="alert-box bg-green-100 text-green-900  max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 rounded fixed top-0 right-0" role="alert">
            <span class="block sm:inline">{{ $page.props.flash.message }}</span>
        </div>
        <div class="grid grid-cols-1 gap-6 lg:gap-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div v-for="accordion in accordions" :key="accordion.field_name">
                <div class="py-2 px-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <BaseAccordian>
                        <template v-slot:title>
                            <div class="grid grid-cols-2 md:grid-cols-[5fr_1fr] gap-6 lg:gap-8">
                                <div class="grid sm:grid-rows-1 md:grid-cols-[1fr_3fr] items-center">
                                    <p v-bind:class="(accordion.field_name == 'general')?'text-xl':''" class="font-semibold">{{ accordion.title }}</p>
                                    <p>{{ accordion.text }}</p>
                                </div>
                                <DangerButton type="button" class="sm:flex sm:items-center sm:ms-6 justify-center self-start">
                                    Комментарии
                                    <svg
                                        class="ms-2 -me-0.5 h- w-"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </DangerButton>
                            </div>
                        </template>

                        <template v-slot:content>
                            <div class="grid gap-4 lg:gap-4 mt-8">
                                <p class="font-semibold">Добавить комментарий</p>
                                    <textarea
                                        id="accordion.field_name"
                                        v-model="form[accordion.field_name]"
                                        placeholder="Напишите комментарий"
                                    />
                                    <InputError class="mt-2" :message="form.errors.text_comment" />

                                <PrimaryButton @click="addComment" class="place-self-start" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Добавить
                                </PrimaryButton>

                                <div v-if="comments && comments.length > 0" class="grid gap-4 lg:gap-4 mt-6">
                                    <p class="font-semibold">Комментарии</p>
                                    <ul>
                                        <li v-for="comment in comments" :key="comment.id">
                                            <div v-if="comment.field_name == accordion.field_name">
                                                <div class="flex gap-4 lg:gap-6">
                                                    <p class="font-semibold text-gray-700">{{ comment.user_name }}</p>
                                                    <p class="text-gray-500 dark:text-gray-400">{{ new Date(comment.created_at).toLocaleString() }}</p>
                                                </div>
                                                <h6>{{ comment.text_comment }}</h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-else class="grid gap-4 lg:gap-4 mt-6">
                                    <p class="font-semibold">Пока нет комментариев</p>
                                </div>
                            </div>
                        </template>
                    </BaseAccordian>
                </div>
            </div>
        </div>

    <!--
        <div class="grid grid-cols-1 gap-6 lg:gap-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="py-2 px-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 md:grid-cols-[5fr_1fr] gap-6 lg:gap-8">
                    <div class="grid sm:grid-rows-1 md:grid-cols-[1fr_3fr] items-center">
                        <p class="font-semibold">Название</p>
                        <p class="text-xl">{{company.name}}</p>
                    </div>
                    <DangerButton type="button" @click="open = !open" class="sm:flex sm:items-center sm:ms-6 justify-center self-start">
                        Комментарии
                        <svg
                            class="ms-2 -me-0.5 h- w-"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </DangerButton>
                </div>

                <div v-show="open" class="grid gap-4 lg:gap-4 mt-8">
                    <InputLabel for="name" value="Добавить комментарий" />
                        <TextInput
                            id="name"
                            ref="nameInput"
                            type="text"
                            class="block w-full"
                            v-model="form.name"
                            autocomplete="name"
                            placeholder="Напишите комментарий"
                        />
                    <InputError class="mt-2" :message="form.errors.name" />

                    <PrimaryButton @click="addComment" class="place-self-start" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Добавить
                    </PrimaryButton>

                    <div v-if="comments && comments.length > 0" class="grid gap-4 lg:gap-4 mt-6">
                        <p class="font-semibold">Комментарии</p>
                        <div v-for="comment in comments" :key="comment.id">
                            <div class="flex gap-4 lg:gap-6">
                                <p class="font-semibold text-gray-700">{{ comment.user_name }}</p>
                                <p class="text-gray-500 dark:text-gray-400">{{ new Date(comment.created_at).toLocaleString() }}</p>
                            </div>
                            <h6>{{ comment.text_comment }}</h6>
                        </div>
                    </div>
                </div>               
            </div>
            
            <div class="py-2 px-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 md:grid-cols-[5fr_1fr] gap-6 lg:gap-8">
                    <div class="grid sm:grid-rows-1 md:grid-cols-[1fr_3fr] items-center">
                        <p class="font-semibold">ИНН</p>
                        <p class="text-xl">{{company.inn}}</p>
                    </div>
                    <DangerButton type="button" @click="open = !open" class="sm:flex sm:items-center sm:ms-6 justify-center self-start">
                        Комментарии
                    </DangerButton>
                </div>

                <div v-show="open" class="grid gap-4 lg:gap-4 mt-8">
                    <InputLabel for="inn" value="Добавить комментарий" />
                        <TextInput
                            id="inn"
                            ref="innInput"
                            type="text"
                            class="block w-full"
                            v-model="form.inn"
                            autocomplete="inn"
                            placeholder="Напишите комментарий"
                        />
                    <InputError class="mt-2" :message="form.errors.inn" />

                    <PrimaryButton @click="addComment" class="place-self-start" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Добавить
                    </PrimaryButton>

                    <div v-if="comments && comments.length > 0" class="grid gap-4 lg:gap-4 mt-6">
                        <p class="font-semibold">Комментарии</p>
                        <div v-for="comment in comments" :key="comment.id">
                            <div class="flex gap-4 lg:gap-6">
                                <p class="font-semibold text-gray-700">{{ comment.user_name }}</p>
                                <p class="text-gray-500 dark:text-gray-400">{{ new Date(comment.created_at).toLocaleString() }}</p>
                            </div>
                            <h6>{{ comment.text_comment }}</h6>
                        </div>
                    </div>
                </div>               
            </div>
            
            <div class="py-2 px-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 md:grid-cols-[5fr_1fr] gap-6 lg:gap-8">
                    <div class="grid sm:grid-rows-1 md:grid-cols-[1fr_3fr] items-center">
                        <p class="font-semibold">Общая информация</p>
                        <p>{{company.info}}</p>
                    </div>
                    <DangerButton class="sm:flex sm:items-center sm:ms-6 self-start">
                        Комментарии
                    </DangerButton>
                </div>                
            </div>
        </div>
        -->
    </AuthenticatedLayout>
</template>
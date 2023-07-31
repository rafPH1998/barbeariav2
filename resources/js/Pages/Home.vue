<template>

    <Head title="Tela inicial"/>

    <nav-bar>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

            <Link :href="route('register')" 
                class="text-white hover:bg-white/10 
                px-5 py-2 rounded-lg transition ease-in-out 
                delay-150 hover:-translate-y-1 hover:scale-110 
                hover:duration-300 text-xs">
                Registre-se
            </Link>

            <Link :href="route('login')" 
                class="text-white ml-6 hover:bg-white/10 
                px-5 py-2 rounded-lg transition ease-in-out 
                delay-150 hover:-translate-y-1 hover:scale-110 
                hover:duration-300 text-xs"
                :class="{ 'bg-white/10': $page.url === '/login' }">
                Login
            </Link>
        </div>
    </nav-bar>

    <div class="min-h-screen bg-gray-100 opacity-50" id="body-content"></div>
    <div class="top-0 absolute mt-48 ml-28 container mx-auto animate__animated animate__fadeInDown">
        <h1 class="text-white" id="title">Corte, estilo e tradição - tudo em um só lugar!</h1>
        <h6 class="mt-10 text-white">Não tem comparação de uma barba feita em casa com uma barba feita no barbeiro.<br>     
            Homens também precisam de cuidados. Venha conhecer nosso barbeiro e descubra uma nova barba, um novo mundo!<br>
            Um barbeiro que ama o que faz sempre será melhor que qualquer outro.<br>
            Um homem precisa de poucas coisas na vida: amor, dinheiro e um bom barbeiro. O barbeiro é o melhor companheiro do homem.<br>
            Barbeiro sabe que a beleza está nos mínimos detalhes.<br>
            99% dos seus problemas podem ser resolvidos nos conhecendo =)
        </h6>
    </div>

    <div class="flex justify-center mt-10">
        <h1 class="text-white">Algumas das avaliações de nossos clientes!</h1>
    </div>

    <div class="flex justify-center flex-wrap">
        <CardAssessments
            :username="'William'"
            :date="'05/05/2023'"
            :comment="'Melhor barbearia da região!!'"
        />

        <CardAssessments
            :username="'Rafael'"
            :date="'05/08/2023'"
            :comment="'Barbearia sensacional com um serviço total diferenciado'"
        />

        <CardAssessments
            :username="'Wesley'"
            :date="'15/06/2023'"
            :comment="'Não corto em outro lugar'"
        />

        <CardAssessments
            :username="'João'"
            :date="'20/04/2023'"
            :comment="'Os dois barbeiros são de altissimo nível. Parabéns.'"
        />
    </div>
    <Footer/>
</template>

<script setup>
    import { Link, Head } from '@inertiajs/vue3';
    import NavBar from '../Pages/Layouts/NavBar.vue';
    import Footer from '../Pages/Layouts/Footer.vue';
    import CardAssessments from '../components/CardAssessments.vue';
</script>

<style>
#title {
    font-size: 40px;
}

#body-content {
    height: 500px;
    background-image: url(/assets/images/salao.jpg);
    background-position: center;
    background-size: cover;
    
}
</style>
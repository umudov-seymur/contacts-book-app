<template>
  <div class="m-auto text-center w-96">
    <p class="text-9xl font-sans text-blue-500 error-text">404</p>
    <p
      class="text-grey-darker text-2xl md:text-3xl font-light mb-8 leading-normal"
    >
      Sorry, the page you are looking for could not be found.
    </p>
    <router-link
      :to="{ name: 'home' }"
      class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg"
    >
      Go Home
    </router-link>
  </div>
</template>

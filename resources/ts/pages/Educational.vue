<script lang="ts" setup>
    import Educational from '@/pages/editEducation.vue'

    // import type { InvoiceData } from '@/pages/types.d'

    interface Props {
      id: number
    }
    
    const props = defineProps < Props > ()



  const Data = ref({
    education: [],
})


</script>

<template>

        <!-- Educational Background -->
        <section>
          <Educational :Data="Data" />
        </section>
    <!-- Educational Background ends here -->
</template>

<script setup lang="ts">


const emit = defineEmits(['closedialog'])

const isDialogVisible = ref(false)
const timer = ref()
const totalTime = ref(25 * 60)
const min = ref()
const sec = ref()
const resetButton = ref(false)
const userTime = ref(25)
const edit = ref(false)
const audio = ref()

const startTimer = () =>{
    timer.value = setInterval(() => countDown(),1000 )
    resetButton.value = true
    edit.value = false
}

const stopTimer = () =>{
    clearInterval(timer.value)
    resetButton.value = true
    emit('closedialog')
}

const resetTimer = () => {
  totalTime.value = userTime.value * 60;
  clearInterval(timer.value);
  timer.value = null;
  resetButton.value = false;

  // Update computed properties
  min.value = padTime(Math.floor(totalTime.value / 60));
  sec.value = padTime(totalTime.value % 60);
}

const countDown = () => {
  totalTime.value--;
  if (totalTime.value === 0) {
    audio.value.currentTime = 0;
    audio.value.play();
    clearInterval(timer.value);
    timer.value = null;
    resetButton.value = false;
  }
}
const padTime = (time: any ) =>{
    return (time < 10 ? '0' : '') + time
}

const minutes = computed(() =>{
    min.value = Math.floor(totalTime.value / 60)
    return padTime(min.value)
})

const seconds = computed(() => {
    sec.value = totalTime.value - (min.value * 60)
    return padTime(sec.value)
})

const editTimer = () =>{
    edit.value = !edit.value
}


</script>

<template>

        <!-- Dialog close btn -->
        <!-- <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" /> -->

        <!-- Dialog Content -->
        <VCard>
            <VCardText>
                <VCardText class="mb-3">
                    <h1 align="center" class="col-12 px-2"
                        style="color: rgb(255, 255, 255); text-shadow: rgb(255, 0, 0) 0px 0px 3px, rgb(0, 0, 255) 0px 0px 5px;">
                        <audio ref="audio" src="/audio/ayaw-kol-bata-pa-ko.mp3"></audio>
                        {{ minutes }} : {{ seconds }}</h1>
                </VCardText>
                <div class="d-flex justify-center">
                    <v-btn variant="tonal" color="primary" size="large" width="500px" v-if="!timer" @click="startTimer">
                        Logout
                    </v-btn>
                    <v-btn variant="tonal" color="primary" size="large" width="500px" v-else @click="stopTimer">
                        Login
                    </v-btn>
                </div>
            </VCardText>
            <VCardText class="d-flex justify-end flex-wrap gap-3">
                <VBtn variant="tonal" v-if="resetButton" @click="resetTimer">
                    <VIcon size="24" icon="icon-park-outline:undo">
                    </VIcon>
                </VBtn>
                <VBtn color="info" v-if="!timer" @click="editTimer" >
                    {{ resetButton ? 'Edit' : 'Edit' }}
                    <VIcon size="24" icon="tabler-edit">
                    </VIcon>
                </VBtn>
                <v-text-field v-if="edit" v-model="userTime"></v-text-field>
            </VCardText>
        </VCard>
</template>

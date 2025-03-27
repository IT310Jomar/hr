<script setup lang="ts">
import { ref, reactive, onMounted, watch, nextTick } from 'vue';
import Vue3Signature from 'vue3-signature';

const isDialogVisible = ref(false);
const state = reactive({
  count: 0,
  option: {
    penColor: "rgb(0, 0, 0)",
    backgroundColor: "rgb(255,255,255)"
  },
  disabled: false
});

const signatureData = ref<string | null>(null);
const signature1 = ref();

const saveSignature = () => {
  if (signature1.value) {
    const signatureData = signature1.value?.$refs.canvas?.getSignatureData();
    localStorage.setItem('signatureData', signatureData);
  }
};

const clearSignature = () => {
  signatureData.value = null;
  signature1.value?.clear();
};

const undoSignature = () => {
  signature1.value?.undo();
};

watch(signatureData, (newSignatureData) => {
  if (newSignatureData) {
    signature1.value?.setSignatureData(newSignatureData);
  }
});

onMounted(async () => {
  const savedSignatureData = localStorage.getItem('signatureData');
  if (savedSignatureData) {
    // Use nextTick to wait until signature1 is initialized
    await nextTick();
    signatureData.value = savedSignatureData;
  }
});
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="700" top="true">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn
      rounded="pill" size="small"
        color="primary"
        v-bind="props" 
        v-model="isDialogVisible" inset
      >Signature
      </VBtn>
    </template>

    <DialogCloseBtn @click="isDialogVisible = false" />

    <v-card >
      <VToolbar color="primary" title="Signature Pad"></VToolbar>
      <!-- Signature Component -->
      <v-card class="mr-5 ml-5 mt-5 mb-5">
        <Vue3Signature ref="signature1" :sigOption="state.option" :w="'1280px'" :h="'400px'" :disabled="state.disabled" class="example" v-model="signatureData"></Vue3Signature>
      </v-card>
      <!-- Action Buttons -->
      <VDivider/>
      <VCardText class="d-flex flex-wrap py-4 gap-4">
        <VSpacer />
        <div class="d-flex align-center flex-wrap justify-right gap-2 py-3 px-1">
          <v-btn @click="saveSignature()">Save</v-btn>
          <v-btn @click="clearSignature()">Clear</v-btn>
          <v-btn @click="undoSignature()">Undo</v-btn>
        </div>
      </VCardText>
    </v-card>
  </VDialog>
</template>

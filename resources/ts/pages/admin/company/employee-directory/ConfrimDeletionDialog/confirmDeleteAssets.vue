<script lang="ts" setup>
const props = defineProps<Props>();
const emit = defineEmits(['close'])
interface Props {
dataId: any
dataIndex: any
removeAssets: Function


}

function closeDialog(){
  emit('close')
}

function submitApproved(){
  props.removeAssets(props.dataIndex,props.dataId)
  closeDialog();
}

</script>

<template>
  <section>
   <DialogCloseBtn @click.prevent="closeDialog" />
        <VCard title="Are You Sure?" >
            <VCardText style="text-align: center;">
              <VIcon size="80" color="error">healthicons:alert-circle-outline</VIcon>&nbsp; <h3>You want to delete this data?</h3>
            </VCardText>

            <VCardText class="d-flex justify-end gap-3 flex-wrap">
                <VBtn color="error" variant="tonal"  @click.prevent="closeDialog">
                  No!
                </VBtn>
                <VBtn @click.prevent="submitApproved">
                  Yes!
                </VBtn>
            </VCardText>
        </VCard>
      </section>
</template>

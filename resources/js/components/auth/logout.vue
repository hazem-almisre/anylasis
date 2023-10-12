<template>

</template>


<script>
    export default {
        created(){
            sessionStorage.removeItem('token')
            sessionStorage.removeItem('user')
            sessionStorage.removeItem('type')
            Toast.fire({
                type: 'success',
                icon: 'success',
                title: 'Logout Successfully'
            })
            this.$router.push('/')
        }
    }
</script>


<style>

</style>

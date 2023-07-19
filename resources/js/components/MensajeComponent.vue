<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
    
                    <div class="card-body">
                    <p>{{ message }}</p>
                    <input v-model="message">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: {
      message: 'Hello Vue!'
    },
       
    }
</script>

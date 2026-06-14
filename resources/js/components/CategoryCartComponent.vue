<template>
  <a :href="link" class="category-card">
    
    <!-- Image -->
    <div class="category-img-wrapper">
      <img :src="image" :alt="title" class="category-img">
      <div class="category-overlay"></div>
    </div>

    <!-- Contenu -->
    <div class="category-content">
      <div>
        <span class="category-subtitle">{{ subtitle }} {{ currentYear }}</span>
        <h3 class="category-title">{{ title }}</h3>
      </div>
      <div class="category-btn">
        Découvrir <span class="arrow">→</span>
      </div>
    </div>

  </a>
</template>

<script>
export default {
  name: 'CategoryCartComponent',

  props: {
    image: { type: String, required: true },
    title: { type: String, required: true },
    subtitle: { type: String, required: true },
    link: { type: String, required: true }
  },

  data() {
    return {
      currentYear: new Date().getFullYear(),
    };
  }
}
</script>

<style scoped>
.category-card {
  display: block;
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  text-decoration: none;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  height: 320px;
}

.category-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 35px rgba(0,0,0,0.18);
}

.category-img-wrapper {
  position: absolute;
  inset: 0;
}

.category-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.category-card:hover .category-img {
  transform: scale(1.07);
}

.category-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 60%);
  transition: background 0.3s;
}

.category-card:hover .category-overlay {
  background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%);
}

.category-content {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 24px;
  z-index: 2;
}

.category-subtitle {
  display: block;
  color: rgba(255,255,255,0.75);
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  margin-bottom: 6px;
}

.category-title {
  color: white;
  font-size: 28px;
  font-weight: 800;
  margin: 0 0 16px 0;
  text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.category-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: white;
  color: #333;
  padding: 10px 20px;
  border-radius: 50px;
  font-size: 13px;
  font-weight: 700;
  width: fit-content;
  transition: all 0.3s;
}

.category-card:hover .category-btn {
  background: #333;
  color: white;
}

.arrow {
  transition: transform 0.3s;
}

.category-card:hover .arrow {
  transform: translateX(4px);
}
</style>
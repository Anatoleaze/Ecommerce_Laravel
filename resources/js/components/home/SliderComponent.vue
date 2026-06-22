<template>
  <div class="slider-wrapper">
    
    <!-- Slides -->
    <div class="slide" :style="{ backgroundImage: `url(${slides[currentSlide].image})` }">
      
      <!-- Overlay -->
      <div class="slide-overlay"></div>

      <!-- Contenu -->
      <div class="slide-content">
        <span class="slide-tag" :key="'tag-' + currentSlide">
          {{ slides[currentSlide].tag }} {{ currentYear }}
        </span>
        <h2 class="slide-title" :key="'title-' + currentSlide">
          {{ slides[currentSlide].title }}
        </h2>
        <p class="slide-subtitle" :key="'sub-' + currentSlide">
          {{ slides[currentSlide].subtitle }}
        </p>
        <a :href="link.replace(/=.*/, '=' + slides[currentSlide].search)" class="slide-btn">
          Découvrir la collection →
        </a>
      </div>

      <!-- Navigation points -->
      <div class="slide-dots">
        <button 
          v-for="(slide, index) in slides" 
          :key="index"
          @click="goToSlide(index)"
          :class="['dot', { active: currentSlide === index }]">
        </button>
      </div>

      <!-- Flèches navigation -->
      <button class="slide-arrow arrow-left" @click="prevSlide">
        <i class="zmdi zmdi-chevron-left"></i>
      </button>
      <button class="slide-arrow arrow-right" @click="nextSlide">
        <i class="zmdi zmdi-chevron-right"></i>
      </button>

    </div>

  </div>
</template>

<script>
export default {
  name: 'SliderComponent',

  props: {
    link: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      currentYear: new Date().getFullYear(),
      currentSlide: 0,
      autoPlayInterval: null,
      slides: [
        {
          image: 'images/slide-01.jpg',
          tag: 'Collection Femmes',
          title: 'Nouvelle Saison',
          subtitle: 'Découvrez les dernières tendances mode pour femmes',
          search: 'femmes'
        },
        {
          image: 'images/slide-02.jpg',
          tag: 'Collection Hommes',
          title: 'Style & Élégance',
          subtitle: 'Des pièces incontournables pour votre garde-robe',
          search: 'hommes'
        },
        {
          image: 'images/slide-03.jpg',
          tag: 'Accessoires',
          title: 'Complétez votre look',
          subtitle: 'Montres, sacs et chaussures de qualité',
          search: 'montres'
        },
      ]
    };
  },

  methods: {
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % this.slides.length;
    },
    prevSlide() {
      this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
    },
    goToSlide(index) {
      this.currentSlide = index;
    },
    startAutoPlay() {
      this.autoPlayInterval = setInterval(this.nextSlide, 5000);
    },
    stopAutoPlay() {
      clearInterval(this.autoPlayInterval);
    }
  },

  mounted() {
    this.startAutoPlay();
  },

  beforeUnmount() {
    this.stopAutoPlay();
  }
}
</script>

<style scoped>
.slider-wrapper {
  width: 100%;
  position: relative;
}

.slide {
  position: relative;
  width: 100%;
  height: 550px;
  background-size: cover;
  background-position: center;
  transition: background-image 0.5s ease;
  display: flex;
  align-items: center;
}

.slide-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.2) 100%);
}

.slide-content {
  position: relative;
  z-index: 2;
  padding: 0 80px;
  max-width: 600px;
  animation: fadeInUp 0.6s ease;
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to   { opacity: 1; transform: translateY(0); }
}

.slide-tag {
  display: inline-block;
  background: rgba(255,255,255,0.2);
  color: white;
  padding: 6px 16px;
  border-radius: 25px;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  margin-bottom: 16px;
  backdrop-filter: blur(4px);
  border: 1px solid rgba(255,255,255,0.3);
}

.slide-title {
  font-size: 52px;
  font-weight: 800;
  color: white;
  line-height: 1.1;
  margin-bottom: 16px;
  text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.slide-subtitle {
  font-size: 16px;
  color: rgba(255,255,255,0.85);
  margin-bottom: 32px;
  line-height: 1.6;
}

.slide-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: white;
  color: #333;
  padding: 14px 28px;
  border-radius: 50px;
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.slide-btn:hover {
  background: #333;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

/* Flèches */
.slide-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255,255,255,0.15);
  border: 2px solid rgba(255,255,255,0.4);
  color: white;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  cursor: pointer;
  font-size: 22px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  z-index: 3;
  backdrop-filter: blur(4px);
}

.slide-arrow:hover {
  background: rgba(255,255,255,0.3);
  border-color: white;
}

.arrow-left { left: 20px; }
.arrow-right { right: 20px; }

/* Points de navigation */
.slide-dots {
  position: absolute;
  bottom: 25px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
  z-index: 3;
}

.dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: rgba(255,255,255,0.5);
  border: none;
  cursor: pointer;
  transition: all 0.3s;
}

.dot.active {
  background: white;
  width: 28px;
  border-radius: 5px;
}

/* Responsive */
@media (max-width: 768px) {
  .slide {
    height: 400px;
  }
  .slide-content {
    padding: 0 30px;
  }
  .slide-title {
    font-size: 32px;
  }
  .slide-subtitle {
    font-size: 14px;
  }
}
</style>
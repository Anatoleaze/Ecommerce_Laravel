<template>
  <div style="min-height: 100vh; background: #f6f7fb; padding: 50px 0;">

    <div class="container" style="max-width: 1100px;">

      <div style="margin-bottom: 30px;">
        <span style="
          display:inline-block;
          background: rgba(26,26,46,0.08);
          color:#1a1a2e;
          padding:6px 14px;
          border-radius:20px;
          font-size:12px;
          font-weight:800;
          letter-spacing:1px;
          text-transform:uppercase;
          margin-bottom:10px;
        ">
          Commande #{{ order[0].num }}
        </span>

        <h2 style="font-size:28px; font-weight:800; color:#1a1a2e; margin:0;">
          Détails de la commande
        </h2>

        <p style="color:#777; font-size:13px; margin-top:6px;">
          Suivi et gestion de votre commande
        </p>
      </div>

      <div class="row" style="gap: 30px 0;">

        <div class="col-lg-7">

          <div style="
            background:white;
            border-radius:18px;
            padding:24px;
            box-shadow:0 15px 40px rgba(0,0,0,0.06);
          ">

            <h5 style="font-size:15px; font-weight:800; color:#1a1a2e; margin-bottom:18px;">
              🛍️ Produits
            </h5>

            <div v-for="row in order" :key="row.id" style="
                display:flex;
                gap:16px;
                padding:14px 0;
                border-bottom:1px solid #f3f4f6;
                align-items:center;
              ">

              <div @click="openModal(row.product_image, row.product_name)" style="
                  width:70px;
                  height:70px;
                  border-radius:12px;
                  overflow:hidden;
                  background:#f3f4f6;
                  flex-shrink:0;
                  cursor: pointer;
                  transition: transform 0.2s;
                " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <img :src="row.product_image" :alt="row.product_name"
                  style="width:100%; height:100%; object-fit:cover;">
              </div>

              <div style="flex:1;">
                <p style="margin:0; font-weight:700; color:#1a1a2e; font-size:14px;">
                  {{ row.product_name }}
                </p>

                <p style="margin:4px 0 0; font-size:12px; color:#777;">
                  Quantité : <b>{{ row.quantity }}</b>
                </p>
              </div>

            </div>

          </div>
        </div>

        <div class="col-lg-5">

          <div style="
            background:white;
            border-radius:18px;
            padding:24px;
            box-shadow:0 15px 40px rgba(0,0,0,0.06);
          ">

            <h5 style="font-size:15px; font-weight:800; color:#1a1a2e; margin-bottom:18px;">
              📋 Récapitulatif
            </h5>

            <div style="margin-bottom:14px;">
              <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:12px; color:#777; font-weight:700;">Statut</span>

                <span :style="`
                  padding:6px 14px;
                  border-radius:999px;
                  font-size:12px;
                  font-weight:800;
                  background:${getStatusColor(orderLocal.statut).bg};
                  color:${getStatusColor(orderLocal.statut).text};
                `">
                  {{ getStatusLabel(orderLocal.statut) }}
                </span>
              </div>
            </div>

            <div style="margin-bottom:14px;">
              <div style="display:flex; justify-content:space-between;">
                <span style="font-size:12px; color:#777; font-weight:700;">Tracking</span>
                <span style="font-size:12px; font-weight:800; color:#1a1a2e; font-family:monospace;">
                  {{ order[0].num }}
                </span>
              </div>
            </div>

            <div style="margin-bottom:14px;">
              <div style="display:flex; justify-content:space-between;">
                <span style="font-size:12px; color:#777; font-weight:700;">Livraison</span>
                <span style="font-size:13px; font-weight:700; color:#1a1a2e;">
                  {{ order[0].livraison }}
                </span>
              </div>
            </div>

            <div style="
              margin-top:18px;
              padding:16px;
              border-radius:14px;
              background: linear-gradient(135deg, #1a1a2e, #333);
              display:flex;
              justify-content:space-between;
              align-items:center;
            ">
              <span style="color:white; font-weight:700; font-size:13px;">
                Total TTC
              </span>

              <span style="color:#f1c40f; font-size:18px; font-weight:900;">
                {{ order[0].total }} €
              </span>
            </div>

            <div v-if="user.role === 'admin'"
              style="margin-top:20px; border-top:1px solid #f3f4f6; padding-top:16px; display:flex; flex-direction:column; gap:10px;">

              <p style="font-size:12px; font-weight:800; color:#555; margin-bottom:2px;">
                ⚙️ Actions administrateur
              </p>

              <button v-if="orderLocal.statut === 'paye'" @click="changeStatus(order[0].order_id, 'expedie')"
                style="width:100%; padding:12px; background:linear-gradient(135deg, #1a1a2e, #333); color:white; border:none; border-radius:12px; font-size:13px; font-weight:800; cursor:pointer;">
                🚚 Marquer Expédiée
              </button>

              <button v-if="orderLocal.statut === 'expedie'" @click="changeStatus(order[0].order_id, 'livraison')"
                style="width:100%; padding:12px; background:linear-gradient(135deg, #2980b9, #1f618d); color:white; border:none; border-radius:12px; font-size:13px; font-weight:800; cursor:pointer;">
                🚚 Mettre en Livraison
              </button>

              <button v-if="orderLocal.statut === 'livre'" @click="refundOrder(order[0].order_id)"
                :disabled="isRefunding"
                style="width:100%; padding:12px; background:linear-gradient(135deg, #e74c3c, #c0392b); color:white; border:none; border-radius:12px; font-size:13px; font-weight:800; cursor:pointer;"
                :style="isRefunding ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                {{ isRefunding ? '⏳ Traitement du remboursement...' : '💰 Rembourser la commande (Stripe)' }}
              </button>

            </div>

          </div>
        </div>

      </div>
    </div>

    <div v-if="isModalOpen" @click.self="closeModal" style="
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.75);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      padding: 20px;
    ">
      <div
        style="position: relative; max-width: 550px; background: white; padding: 12px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <button @click="closeModal" style="
          position: absolute;
          top: -15px;
          right: -15px;
          background: #1a1a2e;
          color: white;
          border: none;
          border-radius: 50%;
          width: 32px;
          height: 32px;
          font-weight: bold;
          cursor: pointer;
          font-size: 14px;
          display: flex;
          align-items: center;
          justify-content: center;
          box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        ">✕</button>

        <img :src="modalImage" :alt="modalTitle"
          style="width: 100%; height: auto; max-height: 75vh; object-fit: contain; border-radius: 10px;">
        <p style="margin: 10px 0 0; text-align: center; font-weight: 700; color: #1a1a2e; font-size: 14px;">{{
          modalTitle }}</p>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'OrderDetailsComponent',
  props: {
    order: { type: Array, required: true },
    user: { type: Object, required: true },
  },
  data() {
    return {
      orderLocal: { ...this.order[0] },
      isRefunding: false,
      isModalOpen: false,
      modalImage: '',
      modalTitle: '',
    };
  },
  methods: {
    getStatusLabel(statut) {
      return { 'paye': 'Payée', 'expedie': 'Expédiée', 'livraison': 'En cours de livraison', 'livre': 'Livrée', 'rembourse': 'Remboursée' }[statut] || statut;
    },
    getStatusColor(statut) {
      return { 'paye': { bg: '#e8f8f5', text: '#1e8449' }, 'expedie': { bg: '#e8f4fd', text: '#2980b9' }, 'livraison': { bg: '#f4ecf7', text: '#8e44ad' }, 'livre': { bg: '#d4efdf', text: '#196f3d' }, 'rembourse': { bg: '#f2f4f4', text: '#7f8c8d' } }[statut] || { bg: '#f0f0f0', text: '#555' };
    },
    openModal(image, title) {
      this.modalImage = image; this.modalTitle = title; this.isModalOpen = true;
    },
    closeModal() { this.isModalOpen = false; },

    async changeStatus(order_id, targetStatus) {
      try {
        const response = await axios.patch(`/commande/update_status/${order_id}`, { status: targetStatus });
        if (response.data.success) { this.orderLocal.statut = targetStatus; }
      } catch (error) {
        alert("Erreur lors du changement de statut.");
      }
    },

    async refundOrder(order_id) {
      if (!confirm("Voulez-vous rembourser cette commande ?")) return;
      this.isRefunding = true;
      try {
        const response = await axios.post(`/commande/refund/${order_id}`);
        if (response.data.success) {
          alert(response.data.message);
          this.orderLocal.statut = 'rembourse';
        }
      } catch (error) {
        alert(error.response?.data?.error || "Erreur Stripe");
      } finally {
        this.isRefunding = false;
      }
    }
  }
};
</script>
import React from "react";
import "./ProductCard.css";

const ProductCard = ({ product, addToCart }) => {
  let gallery = [];

  // Try to parse the gallery JSON string into an array
  try {
    gallery = JSON.parse(product.gallery);
  } catch (error) {
    console.error("Failed to parse gallery JSON:", product.gallery);
  }

  if (!product || !gallery.length) {
    console.error("Gallery data is missing for product:", product);
    return <div>Product data is not available</div>;
  }

  return (
    <div className="product-card">
      <img
        src={gallery[0]} // Display the first image
        alt={product.name}
        className="product-image"
      />
      <h2>{product.name}</h2>
      <p>
        {product.prices[0].currency_symbol}
        {product.prices[0].amount}
      </p>
      {product.in_stock ? (
        <button onClick={() => addToCart(product)} className="add-to-cart">
          <img src="/path/to/cart-icon.png" alt="Add to cart" />
        </button>
      ) : (
        <div className="out-of-stock">Out Of Stock</div>
      )}
    </div>
  );
};

export default ProductCard;

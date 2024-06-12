import React from "react";
import "./ProductCard.css";

const ProductCard = ({ product, addToCart }) => {
  return (
    <div className="product-card">
      <img
        src={product.gallery[0]}
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
          <img src="path/to/cart-icon.png" alt="Add to cart" />
        </button>
      ) : (
        <div className="out-of-stock">Out Of Stock</div>
      )}
    </div>
  );
};

export default ProductCard;

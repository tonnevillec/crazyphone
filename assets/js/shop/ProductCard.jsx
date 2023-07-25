import React from 'react';

const ProductCard = ({product}) => {
    return <div className="card bg-base-100 shadow-md">
        <img src={"/uploads/" + product.picture}
             className="rounded-tl-box rounded-tr-box"
             alt="{{ product.name }}"/>
        <div className="card-body p-3">
            <h2 className="card-title text-base">
                {product.name}
            </h2>
            <p dangerouslySetInnerHTML={{__html: product.description}}></p>
            <div className="card-actions justify-end">
                <div className="badge text-xs badge-secondary">{product.brand.name}</div>
                <div className="badge text-xs badge-primary">{product.category.title}</div>
                { product.price &&
                    <div className="badge text-xs badge-outline">{product.formattedPrice}</div>
                }
            </div>
        </div>
    </div>;
};

export default ProductCard;

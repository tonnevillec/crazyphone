import React from 'react';

const ProductCard = ({product, affCard}) => {
    return <div className={affCard ? "card bg-base-100 shadow-md" : "card bg-base-100 shadow-md card-side w-full"}>
        <img src={"/uploads/" + product.picture}
             className={affCard ? "rounded-tl-box rounded-tr-box" : "rounded-tl-box rounded-bl-box max-w-[20%]"}
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

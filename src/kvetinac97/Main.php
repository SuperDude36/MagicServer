package kvetinac97;

import cn.nukkit.event.block.BlockBreakEvent;
import cn.nukkit.item.Item;
import cn.nukkit.event.entity.EntityDamageByEntityEvent;
import cn.nukkit.event.entity.EntityDamageEvent;
import cn.nukkit.event.EventHandler;
import cn.nukkit.event.Listener;
import cn.nukkit.Player;
import cn.nukkit.plugin.PluginBase;
import cn.nukkit.Server;

class Main extends PluginBase implements Listener {

    @Override
    public void onEnable() {
        getLogger().info("§dMagic§bServer §aENABLED!");
        getLogger().info("§eRunning version §91.0.1...");
        getServer().getPluginManager().registerEvents(this, this);
    }

    @Override
    public void onDisable() {
        getLogger().info("§dMagic§bServer §4DISABLED!");
    }

    @EventHandler
    public void onDamage(EntityDamageEvent ev){
        if (!(ev.getEntity() instanceof Player)){
            return;
        }
        Player p = (Player) ev.getEntity();

        if (ev instanceof EntityDamageByEntityEvent){
            EntityDamageByEntityEvent e = (EntityDamageByEntityEvent) ev;
            if (!(pl instanceof Player)){
                return;
            }
            Player pl = e.getDamager();
            
            Item it = pl.getInventory().getItemInHand();
            if (!(it.hasEnchantments())){
                return;
            }
            Enchantment[] en = it.getEnchantments();
            for (Enchantment ench : en){
                int lvl = ench.getLevel();
                switch (ench.getId()){
                    case 9:
                        e.setDamage(e.getDamage()+(lvl*1.25));
                        break;
                    case 12:
                        e.setKnockback(e.getKnockBack()+(lvl*0.3));
                        break;
                    case 13:
                        if (!e.isCancelled()){
                            p.setOnFire(lvl*4);
                        }
                        break;
                    case 19:
                        dmg = Math.round(((lvl+1)/4));
                        e.setDamage(e.getDamage()+dmg);
                        break;
                    case 20:
                        e.setKnockBack(e.getKnockBack()+(lvl*0.4));
                        break;
                    case 21:
                        if (!e.isCancelled()){
                            p.setOnFire(5);
                        }
                        break;
                    case 22:
                        pl.getInventory().addItem(Item.ARROW, 0, 1);
                        break;
                }
            }
        }

        for (Item item : p.getInventory().getArmorContents()){
            Enchantment[] eng = item.getEnchantments();
            for (Enchantment enchantment : eng){
                int lvl = enchantment.getLevel();
                switch (enchantment.getId()){
                    case 0:
                        ev.setDamage(ev.getDamage() - ((lvl*0.04)*ev.getDamage()));
                        break;
                    case 1:
                        if (ev.getCause() > 4 && ev.getCause() < 8){
                            ev.setDamage(ev.getDamage() - ((lvl*0.12)*ev.getDamage()));
                        }
                        break;
                    case 2:
                        if (ev.getCause() == 4){
                            ev.setDamage(ev.getDamage() - ((lvl*0.15)*ev.getDamage()));
                        }
                        break;
                    case 3:
                        if (ev.getCause() > 8 && ev.getCause() < 11){
                            ev.setDamage(ev.getDamage() - ((lvl*0.15)*ev.getDamage()));
                        }
                        break;
                    case 4:
                        if (ev.getCause() == 2){
                            ev.setDamage(ev.getDamage() - ((lvl*0.12)*ev.getDamage()));
                        }
                        break;
                    case 7:
                        if (ev instanceof EntityDamageByEntityEvent){
                            EntityDamageByEntityEvent e = (EntityDamageByEntityEvent) ev;
                            Player pl = e.getDamager();
                            EntityDamageEvent evn = null;
                            Server.getInstance().getPluginManager().callEvent(evn = new EntityDamageEvent(pl, 14, lvl*2));
                            if (evn.isCancelled() || evn.getDamage() <= 0){
                                break;
                            }
                            pl.attack(lvl*2, evn);
                        }
                        break;
                }
            }
        }
    }

    public function onBreak(BlockBreakEvent e){
        Player p = e.getPlayer();
        if (!p.getInventory().getItemInHand().hasEnchantments()){
            return;
        }
        Enchantment[] ench = p.getInventory().getItemInHand().getEnchantments();
        foreach (Enchantment en : ench){
            int lvl = en.getLevel();
            switch (en.getId()){
                case 16:
                    Item[] item = new Item[]{e.getBlock()};
                    e.setDrops(item);
                    break;
                case 17:
                    if (mt_rand(1, (6-lvl)) === 2){
                        i = p.getInventory().getItemInHand();
                        i.setDamage(i.getDamage()+1);
                    }
                    break;
                case 18:
                    switch (e.getBlock().getId()){
                        case 16:
                            drop = .mt_rand(3, 3+lvl);
                            e.setDrops([Item::get(263, 0, drop)]);
                            break;
                        case 21:
                            drop = .mt_rand(5, 5+lvl);
                            e.setDrops([Item::get(351, 4, drop)]);
                            break;
                        case 56:
                            drop = .mt_rand(1, 1+lvl);
                            e.setDrops([Item::get(264, 0, drop)]);
                            break;
                        case 73:
                            drop = .mt_rand(5, 5+lvl);
                            e.setDrops([Item::get(331, 0, drop)]);
                            break;
                        case 89:
                            e.setDrops([Item::get(16, 0, 4)]);
                            break;
                        case 129:
                            drop = .mt_rand(1, .round(1+(lvl/3)));
                            e.setDrops([Item::get(129, 0, drop)]);
                            break;
                        case 153:
                            drop = .mt_rand(2, 2+lvl);
                            e.setDrops([Item::get(406, 0, drop)]);
                            break;
                    }
                    break;
            }
        }
    }

}
